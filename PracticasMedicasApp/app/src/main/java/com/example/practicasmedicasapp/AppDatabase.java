package com.example.practicasmedicasapp;

import android.content.Context;

import androidx.room.Database;
import androidx.room.Room;
import androidx.room.RoomDatabase;

// Cambia la versión si agregas campos o entidades nuevas
@Database(entities = {Practica.class}, version = 1, exportSchema = false)
public abstract class AppDatabase extends RoomDatabase {

    private static AppDatabase instance;

    public abstract PracticaDao practicaDao();

    // Singleton para obtener la instancia global de la base de datos
    public static synchronized AppDatabase getInstance(Context context) {
        if (instance == null) {
            instance = Room.databaseBuilder(context.getApplicationContext(),
                            AppDatabase.class, "practicas_db")
                    .allowMainThreadQueries() // Solo para pruebas o proyectos pequeños
                    .build();
        }
        return instance;
    }
}