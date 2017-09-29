# mink_test
Symfony 3.3 code for running Mink tests.

How to use this code:

1) First checkout on your development machine where you plan to run symfony a project based on Symfony 3.3.
For example use the following command: symfony new mink_test 3.3

2) Copy locally to either the dev environment or a host machine this github repository.

3) Copy these sources files to the respective location on the development machine where you created the repository in step 1 above.
For example: "tests/AppBundle/Controller/DefaultControllerTest.php" gets copied to the "tests/AppBundle/Controller/" folder.

4) Setup your test machine and run startx as per my article here: https://alvinbunk.wordpress.com/2016/08/03/using-mink-to-perform-functional-tests-in-symfony3-framework/
5) Make sure you have the 3 terminal windows open as per my above article. i.e. Selenium needs to be running.
6) Run the command "phpunit" from the Symfony root folder.
7) Watch the development machine as the tests automatically open a browser to run the various Mink test. Headless browser tests are run as well.
8) If you get errors, you haven't read the article correctly or you have missed something. Please double check everything!
