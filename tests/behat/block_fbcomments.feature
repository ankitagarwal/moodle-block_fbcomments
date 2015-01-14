@block @block_fbcomments
Feature: Configure and setup Fbcomments block
  In order to use the features of fbcomments block
  As a teacher
  I need to be able to set it up and configure it.

  Background:
    Given the following "courses" exist:
      | fullname | shortname | summary | category |
      | Course 1 | C101      | Proved the course summary block works! |0        |
    And the following "users" exist:
      | username    | firstname | lastname | email            |
      | student1    | Sam       | Student  | student1@asd.com |
      | teacher1    | Teacher   | One      | teacher1@asd.com |
    And the following "course enrolments" exist:
      | user        | course | role    |
      | student1    | C101   | student |
      | teacher1    | C101   | editingteacher |
    And I log in as "teacher1"
    And I follow "Course 1"
    And I turn editing mode on
    And I add the "Facebook comments" block
    And I configure the "Facebook comments" block
    And I press "Save changes"
    And I log out

  @javascript
  Scenario: Student can view Facebook comments
    When I log in as "student1"
    And I follow "Course 1"
    Then "Facebook comments" "block" should exist

  @javascript
  Scenario: Teacher can configure the block.
    When I log in as "teacher1"
    And I follow "Course 1"
    And I turn editing mode on
    And I configure the "Facebook comments" block
    And I set the following fields to these values:
      | Block title                  | Fbcomments             |
      | Block represents             | Content for the course |
      | Theme to use                 | Dark color theme       |
      | Enable Like/recommend button | Recommend              |
      | Enable Share button          | 1                      |
      | Enable comments              | 1                      |
      | Number of comments to show   | 20                     |
      | Order of comments            | Social                 |
      | Facebook App id              | 25                     |
    And I press "Save changes"
    Then I configure the "Fbcomments" block
    And the field "Block title" matches value "Fbcomments"
    And the field "Block represents" matches value "Content for the course"
    And the field "Theme to use" matches value "Dark color theme"
    And the field "Enable Like/recommend button" matches value "Recommend"
    And the field "Enable Share button" matches value "1"
    And the field "Enable comments" matches value "1"
    And the field "Number of comments to show" matches value "20"
    And the field "Order of comments" matches value "Social"
    And the field "Facebook App id" matches value "25"
    And I set the field "Enable Like/recommend button" to "Disable"
    And the "Enable Share button" "checkbox" should be disabled
    And I set the field "Enable Like/recommend button" to "Like"
    And the "Enable Share button" "checkbox" should be enabled
