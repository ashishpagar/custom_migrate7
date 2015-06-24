<?php
/**
 * @file
 * Contains \Drupal\custom_migrate7\Plugin\migrate\source\Vocabulary.
 */

namespace Drupal\custom_migrate7\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 7 vocabularies source from database.
 *
 * @MigrateSource(
 *  id = "d7_taxonomy_vocabulary",
 *  source_provider = "taxonomy"
 * )
 */
class Vocabulary extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('taxonomy_vocabulary', 'v')
      ->fields('v', array(
          'vid',
          'name',
          'description',
          'hierarchy',
          'module',
          'weight',
          'machine_name'
      ));
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'vid' => $this->t('The vocabulary ID.'),
      'name' => $this->t('The name of the vocabulary.'),
      'description' => $this->t('The description of the vocabulary.'),
      'help' => $this->t('Help text to display for the vocabulary.'),
      'relations' => $this->t('Whether or not related terms are enabled within the vocabulary. (0 = disabled, 1 = enabled)'),
      'hierarchy' => $this->t('The type of hierarchy allowed within the vocabulary. (0 = disabled, 1 = single, 2 = multiple)'),
      'weight' => $this->t('The weight of the vocabulary in relation to other vocabularies.'),
      'parents' => $this->t("The Drupal term IDs of the term's parents."),
      'node_types' => $this->t('The names of the node types the vocabulary may be used with.'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['vid']['type'] = 'integer';
    return $ids;
  }
}