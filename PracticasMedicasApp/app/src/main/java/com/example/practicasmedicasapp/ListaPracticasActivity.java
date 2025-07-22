package com.example.practicasmedicasapp;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class ListaPracticasActivity extends AppCompatActivity {
    private RecyclerView recyclerPracticas;
    private PracticaAdapter practicaAdapter;
    private AppDatabase db;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lista_practicas);

        recyclerPracticas = findViewById(R.id.recyclerPracticas);
        recyclerPracticas.setLayoutManager(new LinearLayoutManager(this));

        db = AppDatabase.getInstance(this);
        List<Practica> lista = db.practicaDao().obtenerTodas();
        practicaAdapter = new PracticaAdapter(lista);

        recyclerPracticas.setAdapter(practicaAdapter);
    }
}