<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\ColoniaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colonia extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'colonias';

    protected $fillable = [
        'id', 'colonia', 'cp','altitud','latitud','longitud','codigopostal_id','comunidad_id','tipocomunidad_id',
    ];

    public function scopeFilterBy($query, $filters){
        return (new ColoniaFilter())->applyTo($query,$filters);
    }

    public function codigoPostal() {
        return $this->hasOne(Codigopostal::class,'id','codigopostal_id');
    }

    public function comunidad() {
        return $this->hasOne(Comunidad::class,'id','comunidad_id');
    }

    public function tipoComunidad() {
        return $this->hasOne(Tipocomunidad::class,'id','tipocomunidad_id');
    }

    public static function findOrImport($colonia,$cp,$altitud,$latitud,$longitud,$codigospostal_id,$comunidad_id,$tipocomunidad_id){
        $obj = static::where('colonia', $colonia)
            ->first();
        if (!$obj) {
            if ( Codigopostal::all()->contains( $codigospostal_id) ){
                $obj = static::create([
                    'colonia' => strtoupper($colonia),
                    'cp' => strtoupper($cp),
                    'altitud' => $altitud,
                    'latitud' => $latitud,
                    'longitud' => $longitud,
                    'codigopostal_id' => $codigospostal_id,
                    'comunidad_id' => $comunidad_id,
                    'tipocomunidad_id' => $tipocomunidad_id,
                ]);


            }
        }
        return $obj;
    }



}
