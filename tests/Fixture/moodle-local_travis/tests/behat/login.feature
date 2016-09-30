@local @local_travis
Feature: Authentication
  In order to validate my credentials in the system
  As a user
  I need to log into the system

  Scenario: Log in with the predefined admin user with Javascript disabled
    Given I log in as "admin"
    Then I should see "You are logged in as Admin User" in the "page-footer" "region"

  @javascript
  Scenario: Log in with the predefined admin user with Javascript enabled
    Given I log in as "admin"
    Then I should see "You are logged in as Admin User" in the "page-footer" "region"
