<?php

namespace Drupal\Tests\group_node_pevb\Functional;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Tests\group_node_pevb\Traits\GroupContentTypeTrait;
use Drupal\Tests\BrowserTestBase;
use Drupal\og\Og;

/**
 * Test description.
 *
 * @group group_node_pevb
 */
class GroupSubscribeCtaTest extends BrowserTestBase {
  use GroupContentTypeTrait;
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'group_node_pevb',
    'user',
    'node',
    'og_group',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Set up the test here.
    // Create Admin_user.
    $admin_user = $this->drupalCreateUser(['administer rules']);
    // The Admin_user logs in & creates the Group content type.
    $this->drupalLogin($admin_user);
    $this->createGroupContentType();
    // Make the group content type an OG group.
    Og::addGroup('node', 'group');

    $title = 'Working wonders';
    /** @var \Drupal\node\Entity\NodeType $node_type */
    $node_type = 'group';
    $body = 'There is always way to the wonders of the world.';
    // Create node of type Group.
    $this->createGroupNode($title, $node_type, $body, $admin_user);
    // Logs out.
    $this->drupalLogout($admin_user);

  }

  /**
   * Test the Group node can be reached and that the $normal_user can access it.
   *
   * Test that the user can click the subscribe link.
   */
  public function testGroupNodePage() {
    // Create and login as a normal user.
    $normal_user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($normal_user);

    // Start the browsing session.
    $session = $this->assertSession();

    // Navigate to the created Group node page and confirm we
    // can reach it.
    // The page.
    $this->drupalGet('/node/1');
    // Confirm.
    $session->statusCodeEquals(200);

    $this->drupalGet('group/node/1/subscribe/default');
    // Confirm.
    $session->statusCodeEquals(200);

    // Find the new group node created in setup().
    /** @var \Drupal\Core\Entity\Query\QueryInterface $query */
    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'group')->accessCheck(FALSE);
    $results = $query->execute();
    $session->assert(count($results) === 1, 'One group node was found.');

    $entity_type_manager = \Drupal::entityTypeManager();
    $node_storage = $entity_type_manager->getStorage('node');
    /** @var \Drupal\node\Entity\Node $node */
    $node = $node_storage->load(reset($results));
    $entity_type = $node->getEntityTypeId();
    $node_id = $node->id();
    $node_title = $node->label();

    // Click the link.
    /** @var \Drupal\Component\Render\MarkupInterface $label */
    $subscribe_link = 'group/' . $entity_type . '/' . $node_id . '/subscribe/default';

    $name = \Drupal::currentUser()->getAccountName();

    // Display subscription CTA.
    \Drupal::messenger()->addStatus($this->t('Hi %name, <u><strong><a href="%link">click here</a></u></strong> if you would like to subscribe to this group called %label.', [
      '%name' => $name,
      '%label' => $node_title,
      '%link' => $subscribe_link,
    ]));

    // Check that link with this text exist.
    $session->assert->LinkExists('click here');
    // Click the link.
    $session->assert->getPage()->clickLink('click here');

  }

}
