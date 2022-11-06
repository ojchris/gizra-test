<?php

namespace Drupal\Tests\group_node_pevb\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test description.
 *
 * @group group_node_pevb
 */
class GroupSubscribeCtaTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  public static $modules = ['group_node_pevb'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testSomething() {
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin');
    $this->assertSession()->elementExists('xpath', '//h1[text() = "Administration"]');
  }

}
