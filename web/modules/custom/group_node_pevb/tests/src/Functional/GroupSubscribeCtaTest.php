<?php

namespace Drupal\Tests\group_node_pevb\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\group_node_pevb\Traits\GroupContentTypeTrait;
use Drupal\og\Og;

/**
 * Test description.
 *
 * @group group_node_pevb
 */
class GroupSubscribeCtaTest extends BrowserTestBase {
  use GroupContentTypeTrait;

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

    // Click the link.
    /** @var \Drupal\Component\Render\MarkupInterface $label */
    $label = 'group/node/1/subscribe/default';
    $this->clickLink($label);
  }

}
