package fr.heroctf.jni;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    private EditText flagEditText;
    private Button checkButton;

    static {
        System.loadLibrary("native-lib");
    }

    public native boolean checkFlag(String inputText);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        this.flagEditText = findViewById(R.id.flagEditText);
        this.checkButton = findViewById(R.id.checkButton);

        this.checkButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                submitFlag();
            }
        });
    }

    private void submitFlag() {
        String inputText = this.flagEditText.getText().toString();

        if (checkFlag(inputText)) {
            Toast.makeText(this, "You can validate the challenge with this flag !",
                    Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(this, "Wrong flag !", Toast.LENGTH_SHORT).show();
        }
    }
}