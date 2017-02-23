<?php

namespace Drupal\estatus_derechos\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\taxonomy\Entity\Term;

class EstatusController extends ControllerBase {

  public function content() {

    $config = \Drupal::service('config.factory')->getEditable('estatus_derechos.settings');

    $resultado = "Mensajes actualizados.";

// Configuración de mensajes

    $plazo = $config->get('plazo_derechos_autor');
    $vidamax = $config->get('vida_maxima');
    $plazoseguro = $plazo+$vidamax;


    $MensajeH[0] = 'Las obras del autor están en dominio público, ya que murió hace mas de '.$plazo.' años.';
    $MensajeM[0] = 'Las obras de la autora están en dominio público, ya que murió hace mas de '.$plazo.' años.';

    $MensajeH[1] = 'Las obras del autor están en dominio privado, ya que murió hace menos de '.$plazo.' años.';
    $MensajeM[1] = 'Las obras de la autora están en dominio privado, ya que murió hace menos de '.$plazo.' años.';

    $MensajeH[2] = 'Las obras del autor están en dominio privado.';
    $MensajeM[2] = 'Las obras de la autora están en dominio privado.';

    $MensajeH[3] = 'Se desconoce la fecha de muerte de este autor, y su fecha de nacimiento no permite inferir el estatus de derecho de autor de sus obras.';
    $MensajeM[3] = 'Se desconoce la fecha de muerte de esta autora, y su fecha de nacimiento no permite inferir el estatus de derecho de autor de sus obras.';

    $MensajeH[4] = 'Si bien no se conoce la fecha de muerte de este autor, ya que nació hace mas de '.$plazoseguro.' años, se puede inferir que sus obras están en dominio público.';
    $MensajeM[4] = 'Si bien no se conoce la fecha de muerte de esta autora, ya que nació hace mas de '.$plazoseguro.' años, se puede inferir que sus obras están en dominio público.';

    $MensajeH[5] = 'Se desconoce la fecha de muerte de este autor, y ni su fecha de nacimiento ni las notas bibliográficas existentes permiten inferir el estatus de derecho de autor de sus obras.';
    $MensajeM[5] = 'Se desconoce la fecha de muerte de esta autora, y ni su fecha de nacimiento ni las notas bibliográficas existentes permiten inferir el estatus de derecho de autor de sus obras.';

    $MensajeH[6] = 'Si bien no se conoce la fecha de muerte de este autor, las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';
    $MensajeM[6] = 'Si bien no se conoce la fecha de muerte de esta autora, las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';

    $MensajeH[7] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, pero las notas bibliográficas existentes permiten afirmar que sus obras están en dominio privado.';
    $MensajeM[7] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, pero las notas bibliográficas existentes permiten afirmar que sus obras están en dominio privado.';

    $MensajeH[8] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, y las notas bibliográficas existentes no permiten inferir el estatus de derecho de autor de sus obras.';
    $MensajeM[8] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, y las notas bibliográficas existentes no permiten inferir el estatus de derecho de autor de sus obras.';

    $MensajeH[9] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, pero las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';
    $MensajeM[9] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, pero las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';

    $MensajeH[10] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, y las notas bibliográficas existentes no permiten inferir el estatus de derecho de autor de sus obras.';
    $MensajeM[10] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, y las notas bibliográficas existentes no permiten inferir el estatus de derecho de autor de sus obras.';

    $MensajeH[11] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, pero las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';
    $MensajeM[11] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, pero las notas bibliográficas existentes permiten inferir que sus obras están en dominio público.';

    $MensajeH[12] = 'Se desconocen las fechas de muerte y de nacimiento de este autor, y se carecen de notas bibliográficas que permitan inferir el estatus de derecho de autor de sus obras.';
    $MensajeM[12] = 'Se desconocen las fechas de muerte y de nacimiento de esta autora, y se carecen de notas bibliográficas que permitan inferir el estatus de derecho de autor de sus obras.';

    $MensajeH[13] = 'Ocurrió un error al calcular el estatus de derecho de autor';
    $MensajeM[13] = 'Ocurrió un error al calcular el estatus de derecho de autor';


    for ($i = 0; $i <= 13; $i++) {
      $query = \Drupal::entityQuery('taxonomy_term')
        ->condition('vid', 'estatus_de_derechos')
        ->condition('name', $i);
      $tid = $query->execute();
      $tidcodigo = key($tid);
      $term = Term::load($tidcodigo);
      $term->field_descripcion_h->setValue($MensajeH[$i]);
      $term->field_descripcion_m->setValue($MensajeM[$i]);
      $term->Save();
    }

    $arreglo['#title'] = 'Estatus de derecho de autor';
    $arreglo['#theme'] = "vista";

   $arreglo['#resultadoMigracion'] = array(
      '#markup' => $resultado,
      '#allowed_tags' => ['li', 'br', 'b', 'ol', 'h2', 'hr'],
    );

    return $arreglo;

  }


}
