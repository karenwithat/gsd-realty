<?php

namespace Drupal\node_Export\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Node Import form.
 */
class NodeImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['paste'] = [
      '#type' => 'textarea',
      '#title' => 'Exported Code',
      '#default_value' => '',
      '#rows' => 15,
      '#description' => t('Paste the code of a node export here and check that new nodes are created or not after clicking on content.'),
      '#wysiwyg' => FALSE,
      '#required' => TRUE,
    ];
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Import'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $json = $form_state->getValue('paste');
    $nodes = json_decode($json, TRUE);
    $batch = [
      'title' => t('Importing Nodes...'),
      'operations' => [],
      'init_message' => t('Imporitng'),
      'progress_message' => t('Processed @current out of @total.'),
      'error_message' => t('An error occurred during processing'),
      'finished' => '\Drupal\node_export\NodeImport::nodeImportFinishedCallback',
    ];
    foreach ($nodes as $node) {
      $batch['operations'][] = [
        '\Drupal\node_export\NodeImport::nodeImport',
        [$node],
      ];
    }
    batch_set($batch);
    drupal_set_message(t('Node has been imported succesfully.'));
  }

}
