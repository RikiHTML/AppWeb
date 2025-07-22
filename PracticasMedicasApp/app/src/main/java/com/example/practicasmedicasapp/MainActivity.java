package com.example.practicasmedicasapp;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.FileProvider;
import androidx.room.Room;

import android.content.Intent;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class MainActivity extends AppCompatActivity {

    private AppDatabase db;
    private EditText etNombreEstudiante, etDescripcion, etImplementos;
    private Button btnTomarFoto, btnGuardar, btnVerLista;
    private ImageView ivFoto;

    private String rutaFotoActual = "";

    // Para tomar la foto
    private ActivityResultLauncher<Intent> tomarFotoLauncher;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        db = Room.databaseBuilder(getApplicationContext(),
                        AppDatabase.class, "practicas_db")
                .allowMainThreadQueries()
                .build();

        etNombreEstudiante = findViewById(R.id.etNombreEstudiante);
        etDescripcion = findViewById(R.id.etDescripcion);
        etImplementos = findViewById(R.id.etImplementos);
        btnTomarFoto = findViewById(R.id.btnTomarFoto);
        btnGuardar = findViewById(R.id.btnGuardar);
        btnVerLista = findViewById(R.id.btnVerLista);
        ivFoto = findViewById(R.id.ivFoto);

        // Inicializa el launcher para tomar foto
        tomarFotoLauncher = registerForActivityResult(
                new ActivityResultContracts.StartActivityForResult(),
                result -> {
                    if (result.getResultCode() == RESULT_OK) {
                        ivFoto.setImageBitmap(BitmapFactory.decodeFile(rutaFotoActual));
                    } else {
                        rutaFotoActual = "";
                        Toast.makeText(this, "Foto no tomada", Toast.LENGTH_SHORT).show();
                    }
                });

        btnTomarFoto.setOnClickListener(v -> tomarFoto());

        btnGuardar.setOnClickListener(v -> guardarPractica());

        btnVerLista.setOnClickListener(v -> {
            Intent intent = new Intent(MainActivity.this, ListaPracticasActivity.class);
            startActivity(intent);
        });
    }

    private void tomarFoto() {
        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (intent.resolveActivity(getPackageManager()) != null) {
            File fotoArchivo = null;
            try {
                fotoArchivo = crearArchivoImagen();
            } catch (IOException ex) {
                Toast.makeText(this, "Error al crear archivo de imagen", Toast.LENGTH_SHORT).show();
            }
            if (fotoArchivo != null) {
                Uri fotoUri = FileProvider.getUriForFile(this,
                        getApplicationContext().getPackageName() + ".fileprovider",
                        fotoArchivo);
                intent.putExtra(MediaStore.EXTRA_OUTPUT, fotoUri);
                tomarFotoLauncher.launch(intent);
            }
        }
    }

    private File crearArchivoImagen() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(null);
        File image = File.createTempFile(
                imageFileName,
                ".jpg",
                storageDir
        );
        rutaFotoActual = image.getAbsolutePath();
        return image;
    }

    private void guardarPractica() {
        String nombre = etNombreEstudiante.getText().toString();
        String descripcion = etDescripcion.getText().toString();
        String implementos = etImplementos.getText().toString();
        String fecha = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date());

        if (nombre.isEmpty() || descripcion.isEmpty() || implementos.isEmpty() || rutaFotoActual.isEmpty()) {
            Toast.makeText(this, "Completa todos los campos y toma una foto", Toast.LENGTH_SHORT).show();
            return;
        }

        Practica practica = new Practica();
        practica.nombreEstudiante = nombre;
        practica.descripcion = descripcion;
        practica.implementos = implementos;
        practica.rutaFoto = rutaFotoActual;
        practica.fecha = fecha;

        db.practicaDao().insertar(practica);

        Toast.makeText(this, "Práctica guardada", Toast.LENGTH_SHORT).show();
        limpiarCampos();
    }

    private void limpiarCampos() {
        etNombreEstudiante.setText("");
        etDescripcion.setText("");
        etImplementos.setText("");
        ivFoto.setImageDrawable(null);
        rutaFotoActual = "";
    }
}