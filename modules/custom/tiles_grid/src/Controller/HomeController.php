<?php

namespace Drupal\tiles_grid\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * An example controller.
 */
class HomeController extends ControllerBase {
  
   /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */

  protected $entityTypeManager;

  /**
   * Returns a render-able array for a test page.
   */

  /**
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  public function content() {
    //Get tile queue items
    $subqueues = $this->entityTypeManager()->getStorage('entity_subqueue')->loadByProperties(['queue' =>['tile'] ]);
    foreach ($subqueues as $subqueue_id => $subqueue) {
           $subqueuesids = $subqueue->get('items')->getValue();  
    }
    //Extract tile node id from tile queue        
    $nodeids = [];
    foreach ($subqueuesids as $nodeid)
    $nodeids[] = $nodeid['target_id'];    

    //Get tile node which has been added in tile queue
    $tiles = $this->entityTypeManager()->getStorage('node')->loadMultiple($nodeids);
    $tilescontent = [];
    
    //Generate list of tile grid template variable
    foreach ($tiles as $tile){
      //Load image url and then generate render array with image style
      $file = $tile->get('field_image')->entity;
      foreach($tile->get('field_image')->getValue() as $file){
        $fid = $file['target_id']; // get file fid;
        $photo = \Drupal\file\Entity\File::load($fid);
        $photoarray = [
          '#theme' => 'image_style',
          '#uri' => $photo->getFileUri(),
          '#alt' => 'image',
          '#style_name' => 'tile'          
        ];        
      }
      //Get selected tags from a tile or article node
      $tags = [];
      if ($tile->get('field_type')->value == 1 ) {
        //Load article tag for article reference tile
        $article = $this->entityTypeManager()->getStorage('node')->load($tile->get('field_article')->target_id);        
        foreach($article->field_tags as $tagentity){
          $tags[] = $tagentity->entity->getName();
        }  
      } else {
        //Tile tag
        foreach($tile->field_tags as $tagentity){
          $tags[] = strtolower($tagentity->entity->getName());
        }  
      }
      //Get youtube video url and remote thumb      
      $youtube = $tile->get('field_youtube')->getValue();
      $youtubecontent = [];
      if ($youtube) {
        $video_id = $youtube[0]['video_id'];
        $youtubecontent['thumb'] = youtube_build_remote_image_path($video_id) ;
        $youtubecontent['url'] = 'https://www.youtube.com/embed/'.$video_id. '?width=560&height=315&iframe=true&autoplay=1';        
      }            
      //Template variables
      $tilescontent[] = [ 'type' => $tile->get('field_type')->value, 'title' => $tile->get('title')->value, 'body' => $tile->get('body')->value, 'field_tags' => $tags, 'field_image' => $photoarray, 'field_link' => $tile->get('field_link')->getValue(), 'field_youtube' => $youtubecontent, 'field_article' => $tile->get('field_article')->target_id ];
    }   
  
    $build = [
      '#theme' => 'tile',
      '#tiles' => $tilescontent,
      '#cache' => [
        'max-age' => 0,
      ],      
    ];
    //Include Isotope js and custom css and material icon.
    $build['#attached']['library'][] = 'tiles_grid/isotope';
    $build['#attached']['library'][] = 'tiles_grid/icons';      
    $build['#attached']['library'][] = 'tiles_grid/tilecss';      
    return $build;
  }

}