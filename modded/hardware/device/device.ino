#include <WiFiMan.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

#define CONTROL_PIN 13

Config conf;
WiFiClient espClient;
PubSubClient client(espClient);
int state;

void initDevice()
{
    pinMode(CONTROL_PIN,OUTPUT);
    state = 0;
    digitalWrite(CONTROL_PIN,state);
}

void reconnect() 
{
  while (!client.connected()) 
  {
    Serial.print("Attempting MQTT connection...");
    if (client.connect(conf.mqttId,conf.mqttPub,2,true,"0")) 
    {
      Serial.println("connected");
      //sub-pub
      client.publish(conf.mqttPub, String(state).c_str(),true);
      client.subscribe(conf.mqttSub);
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


void initMqtt()
{
    client.setServer(conf.mqttAddr, conf.mqttPort);
    client.setCallback(callback);
}

void callback(char* topic, byte* payload, unsigned int length) 
{
    if(strcmp(topic,conf.mqttSub) == 0)
    {
        if(state)
            state = 0;
        else
            state = 1;
        digitalWrite(CONTROL_PIN,state);
        client.publish(conf.mqttPub, String(state).c_str(),true);
    }
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
    reconnect();
    client.loop();
}