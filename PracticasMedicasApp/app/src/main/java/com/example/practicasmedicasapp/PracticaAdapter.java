package com.example.practicasmedicasapp;

import android.graphics.BitmapFactory;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class PracticaAdapter extends RecyclerView.Adapter<PracticaAdapter.ViewHolder> {

    private final List<Practica> listaPracticas;

    public PracticaAdapter(List<Practica> listaPracticas) {
        this.listaPracticas = listaPracticas;
    }

    @NonNull
    @Override
    public PracticaAdapter.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View vista = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_practica, parent, false);
        return new ViewHolder(vista);
    }

    @Override
    public void onBindViewHolder(@NonNull PracticaAdapter.ViewHolder holder, int position) {
        Practica practica = listaPracticas.get(position);
        holder.tvNombreEstudiante.setText(practica.nombreEstudiante);
        holder.tvDescripcion.setText(practica.descripcion);
        holder.tvFecha.setText(practica.fecha);

        // Mostrar miniatura de la foto
        if (practica.rutaFoto != null && !practica.rutaFoto.isEmpty()) {
            holder.ivFotoMini.setImageBitmap(BitmapFactory.decodeFile(practica.rutaFoto));
        } else {
            holder.ivFotoMini.setImageResource(R.drawable.ic_launcher_background); // O un icono por defecto
        }
    }

    @Override
    public int getItemCount() {
        return listaPracticas.size();
    }

    static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView ivFotoMini;
        TextView tvNombreEstudiante, tvDescripcion, tvFecha;

        ViewHolder(View itemView) {
            super(itemView);
            ivFotoMini = itemView.findViewById(R.id.ivFotoMini);
            tvNombreEstudiante = itemView.findViewById(R.id.tvNombreEstudiante);
            tvDescripcion = itemView.findViewById(R.id.tvDescripcion);
            tvFecha = itemView.findViewById(R.id.tvFecha);
        }
    }
}