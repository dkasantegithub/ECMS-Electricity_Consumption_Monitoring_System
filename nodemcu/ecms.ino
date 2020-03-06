
//********************NODEMCU LIBRARY********************//
  #include <ESP8266WiFi.h>    
  #include <WiFiClient.h> 
  #include <ESP8266WebServer.h>
  #include <ESP8266HTTPClient.h>
  
//********************LCD LIBRARY************************//
//  #include <LiquidCrystal.h>
//  LiquidCrystal lcd(7, 6, 5, 4, 3, 2);
  
//******DECLARATION & INITIALIZATION OF VARIABLES********//
  int lowPause = 10000;      //OFF led for 10s
  int highPause = 250;       //ON for 0.25s
  float pulseRate = 0;       //pulse rate
  int ldrValue = 0;          //value of ldr
  float energyConsumed = 0;  //consumed power
  const char* ssid = "KNUST WIFI";                                              // Your wifi Name       
  const char* password = "7jtkqq3";                                             // Your wifi Password  Hiiijay123
  const char* host = "10.77.100.99";                                            //Your pc or server (database) IP
  const char* serverName = "http://10.77.100.99/nodemcu/InsertDB.php";          //Your domain name and url path or IP address with path
  const int ldrPin = A0;                                                        //ldr to detect light from pulsating LED
  unsigned long previousMillis = 0;                                             // will store the last time a blink was detected
  const long interval = 30000;                                                  // interval at which to blink (milliseconds) 30s
  

//******************************SET-UP********************//
void setup() {
      Serial.begin(115200);   //set serial port
//      pinMode(ledPin,OUTPUT); //set led pin mode
      pinMode(ldrPin,INPUT);  //set ldr pin mode

      WiFi.mode(WIFI_OFF);          //prevents reconnection issue (taking too long to connect)
      delay(500);                  //delay for one second
      WiFi.mode(WIFI_STA);          //this line hides the viewing of ESP as wifi hotspot
      WiFi.begin(ssid, password);   //connect to your WiFi router
    
      Serial.println("");
      Serial.print("Connecting");
      while (WiFi.status() != WL_CONNECTED) {   // waits for connection
        delay(500);                             //delay for 3/4 of a second
        Serial.print(".");
      }
                                                
      Serial.println("");                       //If connection successful, show IP address in serial monitor
      Serial.println("Connected to Network/SSID");
      Serial.print("IP address: ");
      Serial.println(WiFi.localIP());           //IP address assigned to your ESP

//*********************LCD SET-UP*************************//
//    lcd.begin(16,2);
//    lcd.setCursor(0,0);
//    lcd.print("Read(kWh):");
//    lcd.setCursor(12,1);
//    lcd.print("kWh");
}


//******************************LOOP**********************//
void loop() {

  //Check WiFi connection status
  // if(WiFi.status()==WL_CONNECTED){
    
//***************************START HTTP CONNECTION***************************//
      HTTPClient http;                                                     //declare HTTPClient object
      http.begin(serverName);                                              //specify request destination
      http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //specify content-type header
                                                                               
      String httpRequestData, energyData;                                  //prepare your Http POST request data
      unsigned long currentMillis = millis();                              //current time
               
   while((currentMillis - previousMillis) < interval){                     //go thru loop while time is less than 30s
          ldrValue = analogRead(ldrPin);                                   //Read Analog value of LDR
          Serial.println(ldrValue);
          if(ldrValue > 300){                                              //if LED blinks, increase impulse rate by 1
                pulseRate += 1;         
                Serial.print("Current pulse rate: ");
                Serial.println(pulseRate);
          }
                
      }
                delay(5);
                energyConsumed += (pulseRate/1000);                         //assume impulse rate to be 1000imp/kWh
                
                energyData = String(energyConsumed);                        //integer to String conversion
                httpRequestData = "energyConsumed=" + energyData;           //post data
          
                int httpResponseCode = http.POST(httpRequestData);          //Send the request
                //String payload = http.getString();                        //Get the response payload

                Serial.print("Energy consumed: ");
                Serial.print(energyConsumed);
                Serial.println("");
   
               if(httpResponseCode>0){
                     Serial.print("HTTP Response code: ");
                     Serial.println(httpResponseCode);
                  }else{
                     Serial.print("Error code: ");
                     Serial.println(httpResponseCode);
                    }
                previousMillis = currentMillis;                             // save the last time you blinked the LED
                pulseRate = 0;                                              //reset pulse-rate
      http.end();  //Close connection

 //****************************END HTTP CONNECTION******************************//
 
//  }else {
//        Serial.println("WiFi Disconnected");
//  }
}

//********BLINK FUNCTION: DEPICTS PULSATING LED ON ELECTRIC METER***************//
void Blink(){
    digitalWrite(ledPin,LOW);
    delay(lowPause);
    digitalWrite(ledPin,HIGH);
    delay(highPause);
    }



//******************************************************************************//
//ldr and led test function
//  void Test(){
//        digitalWrite(ledPin,LOW);
//        ldrState = analogRead(ldrPin);
//        Serial.print("LED ON: ");
//        Serial.println(ldrState);
//        delay(10000); 
//        digitalWrite(ledPin,HIGH);
//        ldrState = analogRead(ldrPin);
//        Serial.print("LED LOW: ");
//        Serial.println(ldrState);
//        delay(250);
//  }
