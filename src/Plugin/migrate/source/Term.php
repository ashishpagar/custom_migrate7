<?php

/**
 * @file
 * Contains \Drupal\custom_migrate7\Plugin\migrate\source\Term.
 */

namespace Drupal\custom_migrate7\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 7 taxonomy terms source from database
 *
 * @MigrateSource(
 *  id = "d7_taxonomy_term",
 *  source_provider = "taxonomy"
 * )
 */
class Term extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('taxonomy_term_data', 'td')
      ->fields('td', array('tid', 'vid', 'name', 'description', 'weight', 'format'))
      ->distinct();
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'tid' => $this->t('The term ID.'),
      'vid' => $this->t('Existing term VID'),
      'name' => $this->t('The name of the term.'),
      'description' => $this->t('The term description.'),
      'weight' => $this->t('Weight'),
      'parent' => $this->t("The Drupal term IDs of the term's parents."),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $parents = $this->select('taxonomy_term_hierarchy', 'th')
      ->fields('th', array('parent', 'tid'))
      ->condition('tid', $row->getSourceProperty('tid'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('parent', $parents);
    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['tid']['type'] = 'integer';
    return $ids;
  }
}