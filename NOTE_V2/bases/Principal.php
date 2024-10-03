<?php

session_start();

$email = $_SESSION['email'];
$name = $_SESSION['name'];

$computers = [
    'A' => [
        ['id' => 'A01', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'A02', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'A03', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
        ['id' => 'A04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'A05', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'A06', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
        ['id' => 'A07', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'], //disponible
        ['id' => 'A08', 'status' => 'unavailable', 'message' => 'Esta notebook se usando justo ahora, por favor elija otra.'],  //ocupado
        ['id' => 'A09', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'A10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
    ],

    'B' => [
        ['id' => 'B01', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],  //ocupado
        ['id' => 'B02', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'B03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'B04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'B05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
        ['id' => 'B06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'B07', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'], //ocupado
        ['id' => 'B08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
        ['id' => 'B09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'], //ocupado
        ['id' => 'B10', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'], //disponible
    ],

    'C' => [
        ['id' => 'C01', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'C02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],  //ocupado
        ['id' => 'C03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'], //disponible
        ['id' => 'C04', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'], //ocupado
        ['id' => 'C05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],    //mantenimiento
        ['id' => 'C06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'], //disponible
        ['id' => 'C07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],   //disponible
        ['id' => 'C08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //mantenimiento
        ['id' => 'C09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'], //ocupado
        ['id' => 'C10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],   //mantenimiento
    ],

    'D' => [
        ['id' => 'D01', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],  //ocupado
        ['id' => 'D02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],  //ocupado
        ['id' => 'D03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'D04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],  //disponible
        ['id' => 'D05', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],  //ocupado
        ['id' => 'D06', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],  //disponible
        ['id' => 'D07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'D08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'D09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'D10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'E' => [
        ['id' => 'E01', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'E02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'E03', 'status' => 'unavailable', 'message' => 'Esta notebook no esta disponible, por favor elija otra'],
        ['id' => 'E04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'E05', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'E06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'E07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'E08', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'E09', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'E10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],
    
    'F' => [
        ['id' => 'F01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'F02', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'F03', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'F04', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'F05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'F06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'F07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'F08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'F09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'F10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'G' => [
        ['id' => 'G01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'G02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'G03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'G04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'G05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'G06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'G07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'G08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'G09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'G10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'H' => [
        ['id' => 'H01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'H02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'H03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'H04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'H05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'H06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'H07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'H08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'H09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'H10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'I' => [
        ['id' => 'I01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'I02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'I03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'I04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'I05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'I06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'I07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'I08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'I09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'I10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'J' => [
        ['id' => 'J01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'J02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'J03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'J04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'J05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'J06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'J07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'J08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'J09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'J10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'K' => [
        ['id' => 'K01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'K02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'K03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'K04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'K05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'K06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'K07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'K08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'K09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'K10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'L' => [
        ['id' => 'L01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'L02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'L03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'L04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'L05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'L06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'L07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'L08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'L09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'L10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'M' => [
        ['id' => 'M01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'M02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'M03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'M04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'M05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'M06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'M07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'M08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'M09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'M10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'N' => [
        ['id' => 'N01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'N02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'N03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'N04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'N05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'N06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'N07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'N08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'N09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'N10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'O' => [
        ['id' => 'O01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'O02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'O03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'O04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'O05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'O06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'O07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'O08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'O09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'O10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'P' => [
        ['id' => 'P01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'P02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'P03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'P04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'P05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'P06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'P07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'P08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'P09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'P10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'Q' => [
        ['id' => 'Q01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Q02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'Q03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Q04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Q05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Q06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Q07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'Q08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Q09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Q10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'R' => [
        ['id' => 'R01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'R02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'R03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'R04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'R05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'R06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'R07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'R08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'R09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'R10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'S' => [
        ['id' => 'S01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'S02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'S03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'S04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'S05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'S06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'S07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'S08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'S09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'S10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'T' => [
        ['id' => 'T01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'T02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'T03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'T04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'T05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'T06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'T07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'T08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'T09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'T10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'U' => [
        ['id' => 'U01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'U02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'U03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'U04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'U05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'U06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'U07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'U08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'U09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'U10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'V' => [
        ['id' => 'V01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'V02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'V03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'V04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'V05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'V06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'V07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'V08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'V09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'V10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'W' => [
        ['id' => 'W01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'W02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'W03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'W04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'W05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'W06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'W07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'W08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'W09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'W10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'X' => [
        ['id' => 'X01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'X02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'X03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'X04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'X05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'X06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'X07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'X08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'X09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'X10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'Y' => [
        ['id' => 'Y01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Y02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'Y03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Y04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Y05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Y06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Y07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'Y08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Y09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Y10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],

    'Z' => [
        ['id' => 'Z01', 'status' => 'available', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Z02', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra'],
        ['id' => 'Z03', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Z04', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Z05', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Z06', 'status' => 'available', 'message' => 'Esta notebook se encuentra disponible'],
        ['id' => 'Z07', 'status' => 'available', 'message' => 'Esta notebook está disponible'],
        ['id' => 'Z08', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no está disponible hasta nuevo aviso :('],
        ['id' => 'Z09', 'status' => 'unavailable', 'message' => 'Esta notebook no está disponible, por favor elija otra.'],
        ['id' => 'Z10', 'status' => 'maintenance', 'message' => 'Esta notebook se encuentra en mantenimiento, no esta disponible hasta nuevo aviso :(.'],
    ],
    
];

$availableComputers = [];
$unavailableComputers = [];

foreach ($computers as $category => $computersList) {
    foreach ($computersList as $computer) {
        if ($computer['status'] == 'available') {
            $availableComputers[$category][] = $computer;
        } else {
            $unavailableComputers[$category][] = $computer;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Principal</title>
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="../imagenes/OK.png" alt="Escudo" class="logo"> 
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-item">Nombre de Usuario: <br> <?php echo htmlspecialchars($name); ?> <br> Email: <?php echo htmlspecialchars($email); ?></li>  
                <li class="menu-item"><a href="../bases/CerrarSesion.php" class="logout-link">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="status-title">
            <h2>ESTADO DE LAS NOTEBOOKS</h2>
        </div>
        <div class="status-container">
            <?php foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'] as $category): ?>
                <div class="computer-list">
                    <?php foreach ($computers[$category] as $computer): ?>
                        <div class="computer-item" onclick="openModal('modal<?php echo $computer['id']; ?>')">
                            <span><?php echo $computer['id']; ?></span>
                            <div class="status <?php echo $computer['status']; ?>"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php foreach ($computers as $category => $computersList): ?>
        <?php foreach ($computersList as $computer): ?>
            <div id="modal<?php echo $computer['id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('modal<?php echo $computer['id']; ?>')">&times;</span>
                    <p>Mensaje para <?php echo $computer['id']; ?>:</p>
                    <p><?php echo $computer['message']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
