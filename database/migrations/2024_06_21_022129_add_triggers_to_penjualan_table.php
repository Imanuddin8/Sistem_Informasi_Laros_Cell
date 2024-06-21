<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Trigger AFTER INSERT
        DB::unprepared('
            CREATE TRIGGER after_penjualan_insert
            AFTER INSERT ON penjualan
            FOR EACH ROW
            BEGIN
                IF (SELECT kategori FROM produks WHERE id = NEW.produk_id) = "saldo" THEN
                    UPDATE produks
                    SET stok = stok - NEW.jumlah
                    WHERE nama_produk = "saldo";
                ELSE
                    UPDATE produks
                    SET stok = stok - NEW.jumlah
                    WHERE id = NEW.produk_id;
                END IF;
            END
        ');

        // Trigger AFTER UPDATE
        DB::unprepared('
            CREATE TRIGGER after_penjualan_update
            AFTER UPDATE ON penjualan
            FOR EACH ROW
            BEGIN
                DECLARE diff INT;
                SET diff = NEW.jumlah - OLD.jumlah;

                IF (SELECT kategori FROM produks WHERE id = NEW.produk_id) = "saldo" THEN
                    UPDATE produks
                    SET stok = stok - diff
                    WHERE nama_produk = "saldo";
                ELSE
                    UPDATE produks
                    SET stok = stok - diff
                    WHERE id = NEW.produk_id;
                END IF;
            END
        ');

        // Trigger AFTER DELETE
        DB::unprepared('
            CREATE TRIGGER after_penjualan_delete
            AFTER DELETE ON penjualan
            FOR EACH ROW
            BEGIN
                IF (SELECT kategori FROM produks WHERE id = OLD.produk_id) = "saldo" THEN
                    UPDATE produks
                    SET stok = stok + OLD.jumlah
                    WHERE nama_produk = "saldo";
                ELSE
                    UPDATE produks
                    SET stok = stok + OLD.jumlah
                    WHERE id = OLD.produk_id;
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_delete');
    }
};
