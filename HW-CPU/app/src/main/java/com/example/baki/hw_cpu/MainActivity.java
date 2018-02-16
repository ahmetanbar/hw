package com.example.baki.hw_cpu;

import android.content.Intent;
import android.os.Build;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TabHost;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    TabHost tabHost;
    TabHost.TabSpec tb1,tb2,tb3;

    String model_name = Build.MODEL;
    String board = Build.BOARD;
    String brand = Build.BRAND;

    TextView tv;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        tabHost = (TabHost)  findViewById(R.id.tabHost);
        tabHost.setup();

        tb1 = tabHost.newTabSpec("Etiket1");
        tb1.setIndicator(model_name);
        tb1.setContent(R.id.textView7);

        tabHost.addTab(tb1);

        tb2 = tabHost.newTabSpec("Etiket2");
        tb2.setIndicator("Device");
        tb2.setContent(R.id.textView8);
        tabHost.addTab(tb2);

        tb3 = tabHost.newTabSpec("Etiket3");
        tb3.setIndicator("Sensors");
        tb3.setContent(R.id.textView9);
        tabHost.addTab(tb3);



    }
}
