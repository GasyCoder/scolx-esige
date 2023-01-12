<?php
class PrintController extends \BaseController 
{
    public function index()
    {
        $pdf = PDF::loadHTML('<h1>Hello World!!</h1>');
        return $pdf->stream();
    }
}