<?php

class ViewHelper
{
  public static function render($tpl, $data = [], $useLayout = true)
  {
    ob_start();

    if (is_array($data) && count($data))
    {
      foreach ($data as $key => $value)
      {
        $$key = $value;
      }
    }

    include 'views/' . $tpl . '.php';

    $yield = ob_get_contents();

    ob_end_clean();
    ob_start();

    include 'views/_layout.php';

    $out = ob_get_contents();

    ob_end_clean();

    return $out;
  }

  public static function renderPartial($tpl, $data = [])
  {
    return self::render('_' . $tpl, $data);
  }
}