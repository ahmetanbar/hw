package com.example.baki.hw_cpu;

import android.content.Intent;
import android.os.Build;
import android.provider.Settings;
import android.support.v7.app.AppCompatActivity;
import android.app.Activity;
import android.os.Bundle;
import android.widget.TabHost;
import android.widget.TextView;
import java.io.InputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.BufferedReader;

import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.FileReader;

public class MainActivity extends AppCompatActivity implements SensorEventListener {





//                  GENERAL

    String model_name = Build.MODEL;
    String board = Build.BOARD;
    String brand = Build.BRAND;
    String display = Build.DISPLAY;
    String hardware = Build.HARDWARE;
    String fingerprint = Build.FINGERPRINT;
    String id = Build.ID;
    String host = Build.HOST;
    String manufacturer = Build.MANUFACTURER;
    String user = Build.USER;

    //      CPU USAGE

    TextView textView;
    ProcessBuilder processBuilder;
    String Holder = "------------------------------------------------------------------------------------------\n";
    String[] DATA = {"/system/bin/cat", "/proc/cpuinfo"};
    InputStream inputStream;
    Process process;
    byte[] byteArry;
    String [] my;

    private TextView xText,yText,zText;
    private Sensor mySensor;
    private SensorManager SM;

    String Log = "";


    @Override
    protected void onCreate(Bundle savedInstanceState) {


        StringBuffer sb = new StringBuffer();
        sb.append("abi: ").append(Build.CPU_ABI).append("n");
        if (new File("/proc/cpuinfo").exists()) {
            try {
                BufferedReader br = new BufferedReader(new FileReader(new File("/proc/cpuinfo")));
                String aLine;
                while ((aLine = br.readLine()) != null) {
                    sb.append(aLine + "n");
                }
                if (br != null) {
                    br.close();
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
        }




        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Create sensor manager

        SM = (SensorManager)getSystemService(SENSOR_SERVICE);

        //Acc sensor
        mySensor = SM.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);

        //Register sensor listener
        SM.registerListener(this, mySensor, SensorManager.SENSOR_DELAY_NORMAL);

        //Assign Textview
        xText = (TextView)findViewById(R.id.textView22);
        yText = (TextView)findViewById(R.id.textView23);
        zText = (TextView)findViewById(R.id.textView24);




//               RAM USAGE
        long freeSize = 0L;
        long totalSize = 0L;
        long usedSize = -1L;
        try {
            Runtime info = Runtime.getRuntime();
            freeSize = info.freeMemory();
            totalSize = info.totalMemory();
            usedSize = totalSize - freeSize;
        } catch (Exception e) {
            e.printStackTrace();
        }



//                      CPU TEMPERATURE

        float temp = 0;
        Process process;
        try {
            process = Runtime.getRuntime().exec("cat sys/class/thermal/thermal_zone0/temp");
            process.waitFor();
            BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()));
            String line = reader.readLine();
            temp = Float.parseFloat(line) / 1000.0f;

        } catch (Exception e) {
            e.printStackTrace();
        }

        TextView temp_text = (TextView) findViewById(R.id.textView21);
        temp_text.setText("CPU Temperature: "+temp);


//                      CPU READING

        textView = (TextView) findViewById(R.id.textView11);
        byteArry = new byte[1024];

        try {
            processBuilder = new ProcessBuilder(DATA);

            process = processBuilder.start();

            inputStream = process.getInputStream();

            while (inputStream.read(byteArry) != -1) {

                Holder = Holder + new String(byteArry);
//                Holder = Holder + new String(String.valueOf(byteArry[156]));
                my = Holder.split("\n");


            }

            inputStream.close();

        } catch (IOException ex) {

            ex.printStackTrace();
        }


        for (int i=0; i<my.length;i++){
//            textView.setText(my[i]);
            Log = Log + (my[i]) + "\n\n";
            textView.setText(Log);

        }

        

//                       TAB SETTINGS
        TabHost th = (TabHost) findViewById(R.id.tabHost);
        th.setup();

        TextView model_txt = (TextView) findViewById(R.id.textView1);
        model_txt.setText("Model: " + model_name + "\n");

        TextView board_txt = (TextView) findViewById(R.id.textView2);
        board_txt.setText("Board: " + board + "\n");

        TextView brand_txt = (TextView) findViewById(R.id.textView3);
        brand_txt.setText("Brand: " + brand + "\n");

        TextView display_txt = (TextView) findViewById(R.id.textView4);
        display_txt.setText("Display: " + display + "\n");

        TextView hardware_txt = (TextView) findViewById(R.id.textView5);
        hardware_txt.setText("Hardware: " + hardware + "\n");

        TextView fingerprint_txt = (TextView) findViewById(R.id.textView6);
        fingerprint_txt.setText("Fingerprint: " + fingerprint + "\n");

        TextView id_txt = (TextView) findViewById(R.id.textView7);
        id_txt.setText("ID: " + id + "\n");

        TextView host_txt = (TextView) findViewById(R.id.textView8);
        host_txt.setText("Host: " + host + "\n");

        TextView manufacturer_txt = (TextView) findViewById(R.id.textView9);
        manufacturer_txt.setText("Manufactuer: " + manufacturer + "\n");

        TextView user_txt = (TextView) findViewById(R.id.textView10);
        user_txt.setText("User: " + user + "\n");

        TabHost.TabSpec spec = th.newTabSpec("Tag1");
        spec.setContent(R.id.tab1);
        spec.setIndicator("GENERAL");
        th.addTab(spec);

        spec = th.newTabSpec("Tag2");
        spec.setContent(R.id.tab2);
        spec.setIndicator("CPU");
        th.addTab(spec);

        spec = th.newTabSpec("Tag3");
        spec.setContent(R.id.tab3);
        spec.setIndicator("SENSORS");
        th.addTab(spec);

//                          USAGE

        spec = th.newTabSpec("Tag4");
        spec.setContent(R.id.tab4);
        spec.setIndicator("USAGE");
        th.addTab(spec);

        TextView  ram_txt = (TextView) findViewById(R.id.textView31);
        ram_txt.setText("Ram Usage: "+usedSize);

        TextView  total_ram_txt = (TextView) findViewById(R.id.textView32);
        total_ram_txt.setText("Total Ram: "+totalSize);

        TextView  free_ram_txt = (TextView) findViewById(R.id.textView33);
        free_ram_txt.setText("Free Ram: "+freeSize);




    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {
        // Not in use
    }

    @Override
    public void onSensorChanged(SensorEvent event) {
        xText.setText("X Axis: " + event.values[0]);
        yText.setText("Y Axis: " + event.values[1]);
        zText.setText("Z Axis: " + event.values[2]);
    }
}






