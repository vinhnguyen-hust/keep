Feature: Account Registration
    In order to find a way to manage personal tasks
    As a customer
    I want to register for a free account on Keep

    Scenario: I correctly fill out the form
        Given I am on the homepage
        And I click on the link "Sign Up"
        And I submitted the form with all valid values
        Then I should be on the homepage
        And I should see "Check your email address to activate your account."

    Scenario: I submit registration form with all blank fields
        Given I am on registration page
        And I press "Sign Up"
        Then I should be redirected back
        And I should see "The name field is required."
        And I should see "The email field is required."
        And I should see "The password field is required."

    Scenario: I provide an invalid username
        Given I am on registration page
        When I submitted the form with an invalid username
        Then I should be redirected back
        And I should see "The name may only contain letters and spaces."

    Scenario: I provide an invalid email address
        Given I am on registration page
        When I submitted the form with an invalid email address
        Then I should be redirected back
        And I should see "The email must be a valid email address."

    Scenario: I provide a too short password
        Given I am on registration page
        When I submitted the form with a too short password
        Then I should be redirected back
        And I should see "The password must be at least 6 characters."

    Scenario: I provide an invalid password confirmation
        Given I am on registration page
        When I submitted the form with an unmatched password confirmation
        Then I should be redirected back
        And I should see "The password confirmation does not match."