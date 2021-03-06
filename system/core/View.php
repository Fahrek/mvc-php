<?php
/** Vista base del sistema */
class View
{
  /** Template a mostrar */
  protected $template;

  /** Controlador que ejecuta la vista */
  protected $controller_name;

  /** Parámetros a mostrar. Opcional */
  protected $params;

  /**
   * Constructor. Ejecuta el método para renderizar el template
   *
   * @param $controller_name string nombre del controlador invocador
   * @param $params parámetros enviados a ser mostrados en la vista. Opcional
   */
  public function __construct($controller_name, $params = array())
  {
    $this->controller_name = $controller_name;
    $this->params = $params;
    $this->render();
  }

  /**
   * Muestra la vista según el controlador que hizo la petición
   */
  protected function render()
  {
    if(class_exists($this->controller_name)){
      $html_file_name = str_replace('Controller', '', $this->controller_name);
      $this->template = $this->getContentTemplate($html_file_name);
      echo $this->template;
    }else{
      throw new Exception("Error No existe $controller_name");
    }
  }

  /**
   * Retorna el contenido del template html si existe
   *
   * @param $html_file_name string nombre del archivo que contiene la vista
   *
   * @return Contenido del template html
   */
  protected function getContentTemplate($html_file_name)
  {
    $html_path = ROOT . '/' . PATH_VIEWS . "$html_file_name/$html_file_name" . '.php';
    if(is_file($html_path)){
      extract($this->params);
      ob_start();
      require($html_path);
      $template = ob_get_contents();
      ob_end_clean();
      return $template;
    }else{
      throw new Exception("Error No existe $html_path");
    }
  }

}