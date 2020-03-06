   
   int lowPause = 10000;      //OFF led for 10s
   int highPause = 250;       //ON for 0.25s
   const int ledPin = 11;      //depicts pulsating LED on meter
  
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);   //set serial port
  pinMode(ledPin,OUTPUT); //set led pin mode

}

void loop() {
  // put your main code here, to run repeatedly:
//  Serial.print("Current time: ");
//  Serial.println(millis());
    digitalWrite(ledPin,LOW);
    delay(lowPause);
    digitalWrite(ledPin,HIGH);
    delay(highPause);
}