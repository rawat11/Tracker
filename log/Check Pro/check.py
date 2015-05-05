from selenium import webdriver
import unittest
import sys

class ExampleTestCase(unittest.TestCase):
	capabilities = None
	
def setUp(self):
        self.driver = webdriver.Remote(command_executor='http://10.40.14.188:4444/wd/hub',desired_capabilities=self.capabilities)

def test_example(self):
        self.driver.get("http://www.google.com")
        self.assertEqual(self.driver.title, "Google")

def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    ExampleTestCase.capabilities = {
        "browserName": sys.argv[1],
        "platform": sys.argv[2],
    }
    unittest.main()