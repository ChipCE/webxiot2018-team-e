#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>
#include <IRrecv.h>
#include <IRremoteESP8266.h>
#include <IRutils.h>
#include <WiFiMan.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

Config conf;

long lastRead;
long lastSend;

#define READ_INTERVAL 10000
#define SEND_INTERVAL 10000

#define DHTSensor 13
#define DHTTYPE    DHT11
DHT_Unified dht(DHTSensor, DHTTYPE);

#define lightSensor A0

#define inMotionSensor 12
#define outMotionSensor 14


const uint16_t kRecvPin = 5;
const uint32_t kBaudRate = 115200;
const uint16_t kCaptureBufferSize = 1024;
const uint8_t kTimeout = 15;
const uint16_t kMinUnknownSize = 12;
IRrecv irrecv(kRecvPin, kCaptureBufferSize, kTimeout, true);
decode_results results;  // Somewhere to store the results


//data
int temp;
int hum;
int light;
int human;

int irCode;

WiFiClient espClient;
PubSubClient client(espClient);
String tempTopic = "";
String humTopic = "";
String humanTopic = "";
String lightTopic = "";
String irTopic = "";


void initDevice()
{
  //data
  temp = 0;
  hum = 0;
  light = 0;
  human = 0;

  irCode = 0;

  //timer
  lastRead = 0;
  lastSend = 0;

  //DHT11
  dht.begin();
  sensor_t sensor;
  dht.temperature().getSensor(&sensor);
  dht.humidity().getSensor(&sensor);

  //ir
  #if DECODE_HASH
  // Ignore messages with less than minimum on or off pulses.
  irrecv.setUnknownThreshold(kMinUnknownSize);
  #endif                  // DECODE_HASH
  irrecv.enableIRIn();  // Start the receiver
}

void readIR()
{
  irCode = 0;
  
    if (irrecv.decode(&results)) 
  {
    if (results.overflow)
      Serial.printf("overflow");

    if(results.value == 0xFF906F)
      irCode = 1;

    if(results.value == 0xFFB847)
      irCode = 2;
    
    if(results.value == 0xFFF807)
      irCode = 3;

    yield();
  }
}


void readDHT11()
{
  sensors_event_t event;
  dht.temperature().getEvent(&event);
  if (!isnan(event.temperature)) 
  {
    temp=(int)event.temperature;
  }
  dht.humidity().getEvent(&event);
  if (!isnan(event.relative_humidity)) 
  {
    hum=(int)event.relative_humidity;
  }
}

void readLight()
{
  int val = analogRead(lightSensor);
  if(val>300)
    light = 1;
  else
    light = 0;
}

void readMotion()
{
  if(digitalRead(inMotionSensor) && !digitalRead(outMotionSensor))
    human = 1;
  
  if(!digitalRead(inMotionSensor) && digitalRead(outMotionSensor))
    human = 0; 
}

void readSensor()
{
  if(millis()-lastRead >= READ_INTERVAL)
  {
    lastRead = millis();
    readLight();
    readDHT11();
  }
  
  readMotion();
  readIR();
}

void printDebug()
{
  Serial.print(F("Temp : "));
  Serial.println(temp);

  Serial.print(F("Hum : "));
  Serial.println(hum);

  Serial.print(F("Light : "));
  Serial.println(light);

  Serial.print(F("Human : "));
  Serial.println(human);

  Serial.print(F("Ir : "));
  Serial.println(irCode);

  Serial.println(F(""));
}


void reconnect() 
{
  while (!client.connected()) 
  {
    Serial.print("Attempting MQTT connection...");
    if (client.connect(conf.mqttId)) 
    {
      Serial.println("connected");
      lastSend = 0;
    } 
    else 
    {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000);
    }
  }
}

void sendMqtt()
{
  if((millis()-lastSend >= SEND_INTERVAL) || irCode)
  {
    client.publish(tempTopic.c_str(), String(temp).c_str(),true);
    client.publish(humTopic.c_str(), String(hum).c_str(),true);
    client.publish(humanTopic.c_str(), String(human).c_str(),true);
    client.publish(lightTopic.c_str(), String(light).c_str(),true);
    //client.publish(irTopic.c_str(), String(irCode).c_str(),true);
    if(irCode == 1)
      client.publish("light/switch","hubSwitch");
    if(irCode == 2)
      client.publish("fan/switch","hubSwitch");
    if(irCode == 3)
      client.publish("autoswitch","hubSwitch");
    lastSend = millis();
    irCode = 0;
  }
}

void initMqtt()
{
    Serial.println(conf.mqttAddr);
    client.setServer(conf.mqttAddr, conf.mqttPort);
    //client.setCallback(callback);

    tempTopic = String(conf.mqttPub) + "/temp";
    humTopic = String(conf.mqttPub) + "/hum";
    humanTopic = String(conf.mqttPub) + "/human";
    lightTopic = String(conf.mqttPub) + "/light";
    irTopic = String(conf.mqttPub) + "/ir";
}

void callback(char* topic, byte* payload, unsigned int length) {
}


void setup() 
{
  Serial.begin(115200);
  WiFiMan wman = WiFiMan();
  wman.setConfigPin(0);
  wman.start();
  if(wman.getConfig(&conf))
  {
    initDevice();
    initMqtt();
  }
  else
    ESP.deepSleep(0);
}

void loop() 
{
  readSensor();
  reconnect();
  sendMqtt();
  //client.loop();
  //printDebug();
}
