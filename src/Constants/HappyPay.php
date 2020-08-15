<?php


namespace Atxy2k\HappyPay\Constants;


class HappyPay
{
    public const MONEDA = 'MXN';

    public const TP_UNA_SOLA_EXHIBICION = 'C';
    public const TP_3_MESES = 3;
    public const TP_6_MESES = 6;
    public const TP_9_MESES = 9;
    public const TP_12_MESES = 12;
    public const TP_18_MESES = 18;

    public const NOTIFICAR_USUARIO = 1;
    public const NO_NOTIFICAR_USUARIO = 1;

    public const SEGURIDAD_CON_3DS = 1;
    public const SEGURIDAD_SIN_3DS = 0;

    public const COMISION_TRANSFERIDA = 1;
    public const COMISION_NO_TRANSFERIDA = 0;

    public static function tp_disponibles() : array
    {
        return [
            self::TP_UNA_SOLA_EXHIBICION,
            self::TP_3_MESES,
            self::TP_6_MESES,
            self::TP_9_MESES,
            self::TP_12_MESES,
            self::TP_18_MESES,
        ];
    }

}