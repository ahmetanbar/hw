package com.example.baki.hw_cpu;

import android.content.Intent;
import android.os.Build;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TabHost;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

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


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        TabHost th = (TabHost) findViewById(R.id.tabHost);
        th.setup();

        TextView model_txt = (TextView)findViewById(R.id.textView1);
        model_txt.setText("Model: "+model_name+"\n");

        TextView board_txt = (TextView)findViewById(R.id.textView2);
        board_txt.setText("Board: "+board+"\n");

        TextView brand_txt = (TextView)findViewById(R.id.textView3);
        brand_txt.setText("Brand: "+brand+"\n");

        TextView display_txt = (TextView)findViewById(R.id.textView4);
        display_txt.setText("Display: "+display+"\n");

        TextView hardware_txt = (TextView)findViewById(R.id.textView5);
        hardware_txt.setText("Hardware: "+hardware+"\n");

        TextView fingerprint_txt = (TextView)findViewById(R.id.textView6);
        fingerprint_txt.setText("Fingerprint: "+fingerprint+"\n");

        TextView id_txt = (TextView)findViewById(R.id.textView7);
        id_txt.setText("ID: "+id+"\n");

        TextView host_txt = (TextView)findViewById(R.id.textView8);
        host_txt.setText("Host: "+host+"\n");

        TextView manufacturer_txt = (TextView)findViewById(R.id.textView9);
        manufacturer_txt.setText("Manufactuer: "+manufacturer+"\n");

        TextView user_txt = (TextView)findViewById(R.id.textView10);
        user_txt.setText("User: "+user+"\n");




        TabHost.TabSpec spec = th.newTabSpec("Tag1");
        spec.setContent(R.id.tab1);
        spec.setIndicator("Home");
        th.addTab(spec);

        spec= th.newTabSpec("Tag2");
        spec.setContent(R.id.tab2);
        spec.setIndicator("Device");
        th.addTab(spec);

        spec= th.newTabSpec("Tag3");
        spec.setContent(R.id.tab3);
        spec.setIndicator("Sensors");
        th.addTab(spec);



//        tabHost =findViewById(R.id.tabHost);
//        tabHost.setup();
//
//        tb1 = tabHost.newTabSpec("Etiket1");
//        tb1.setIndicator("Home");
//        tb1.setContent();
//        tabHost.addTab(tb1);
//
//        tb2 = tabHost.newTabSpec("Etiket2");
//        tb2.setIndicator("Device");
//        tb2.setContent(R.id.textView8);
//        tabHost.addTab(tb2);
//
//        tb3 = tabHost.newTabSpec("Etiket3");
//        tb3.setIndicator("Sensors");
//        tb3.setContent(R.id.textView9);
//        tabHost.addTab(tb3);



    }

}

