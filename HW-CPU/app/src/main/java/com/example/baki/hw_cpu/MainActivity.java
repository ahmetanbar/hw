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


import android.graphics.Typeface;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.text.Html;
import android.widget.TextView;




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
    String Holder = "";
    String[] DATA = {"/system/bin/cat", "/proc/cpuinfo"};
    InputStream inputStream;
    Process process;
    byte[] byteArry;
    String [] my;
    String [] my2;
    String [] s2;

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
        temp_text.setText( Html.fromHtml("<b> <big>"+ "CPU Temperature:" + "</big> </b>"+ temp +"<br />"));


//                      CPU READING
        textView  = (TextView) findViewById(R.id.textView11);
//        textView.setTypeface(textView.getTypeface(), Typeface.BOLD);
////        textView = (TextView) findViewById(R.id.textView11);
        byteArry = new byte[1024];


        //set text style bold on current font



        try {
            processBuilder = new ProcessBuilder(DATA);

            process = processBuilder.start();

            inputStream = process.getInputStream();

            while (inputStream.read(byteArry) != -1) {

                Holder = Holder + new String(byteArry);
                my = Holder.split("\n");


            }

            inputStream.close();

        } catch (IOException ex) {

            ex.printStackTrace();
        }



        String linetest="";

        for (int i=0; i<my.length;i++){

//            textView.setText(my[i]);

            linetest=my[i];
            int pointer = linetest.indexOf(":");
            int finish=linetest.length();

            String str = Integer.toString(pointer);
            String str2 = Integer.toString(finish);
            if (pointer!=(finish-1)){
                my2 = my[i].split(":");
                Log = Log + ("<b> <big>"+ my2[0] + "</big> </b>") + " : " + (my2[1]) + "\n\n";
            } else{
                Log = Log + ("<b> <big>"+ my[i] + "</big> </b>") + "\n\n";
            }

            textView.setText( Html.fromHtml(Log.replace("\n","<br />")));

        }






//                       TAB SETTINGS
        TabHost th = (TabHost) findViewById(R.id.tabHost);
        th.setup();

        TextView model_txt = (TextView) findViewById(R.id.textView1);
        model_txt.setText( Html.fromHtml("<b> <big>"+ "Model:" + "</big> </b>"+ model_name +"<br />"));

        TextView board_txt = (TextView) findViewById(R.id.textView2);
        board_txt.setText( Html.fromHtml("<b> <big>"+ "Board:" + "</big> </b>"+ board +"<br />"));

        TextView brand_txt = (TextView) findViewById(R.id.textView3);
        brand_txt.setText( Html.fromHtml("<b> <big>"+ "Brand:" + "</big> </b>"+ brand +"<br />"));

        TextView display_txt = (TextView) findViewById(R.id.textView4);
        display_txt.setText( Html.fromHtml("<b> <big>"+ "Display:" + "</big> </b>"+ display +"<br />"));

        TextView hardware_txt = (TextView) findViewById(R.id.textView5);
        hardware_txt.setText( Html.fromHtml("<b> <big>"+ "Hardware:" + "</big> </b>"+ hardware +"<br />"));

        TextView fingerprint_txt = (TextView) findViewById(R.id.textView6);
        fingerprint_txt.setText( Html.fromHtml("<b> <big>"+ "FingerPrint:" + "</big> </b>"+ fingerprint +"<br />"));

        TextView id_txt = (TextView) findViewById(R.id.textView7);
        id_txt.setText( Html.fromHtml("<b> <big>"+ "ID:" + "</big> </b>"+ id +"<br />"));

        TextView host_txt = (TextView) findViewById(R.id.textView8);
        host_txt.setText( Html.fromHtml("<b> <big>"+ "Host:" + "</big> </b>"+ host +"<br />"));

        TextView manufacturer_txt = (TextView) findViewById(R.id.textView9);
        manufacturer_txt.setText( Html.fromHtml("<b> <big>"+ "Manufacturers:" + "</big> </b>"+ manufacturer +"<br />"));

        TextView user_txt = (TextView) findViewById(R.id.textView10);
        user_txt.setText( Html.fromHtml("<b> <big>"+ "User:" + "</big> </b>"+ user +"<br />"));

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
        ram_txt.setText( Html.fromHtml("<b> <big>"+ "Ram Usage:" + "</big> </b>"+ usedSize +"<br />"));

        TextView  total_ram_txt = (TextView) findViewById(R.id.textView32);
        total_ram_txt.setText( Html.fromHtml("<b> <big>"+ "Total Ram:" + "</big> </b>"+ totalSize +"<br />"));


        TextView  free_ram_txt = (TextView) findViewById(R.id.textView33);
        free_ram_txt.setText( Html.fromHtml("<b> <big>"+ "Free Ram: " + "</big> </b>"+ freeSize +"<br />"));




    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {
        // Not in use
    }

    @Override
    public void onSensorChanged(SensorEvent event) {
        xText.setText( Html.fromHtml("<b> <big>"+ "X Axis: " + "</big> </b>"+ event.values[0] +"<br />"));
        yText.setText( Html.fromHtml("<b> <big>"+ "Y Axis: " + "</big> </b>"+ event.values[1] +"<br />"));
        zText.setText( Html.fromHtml("<b> <big>"+ "Z Axis: " + "</big> </b>"+ event.values[2] +"<br />"));
    }
}






