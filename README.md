# IADLearning Moodle Plugin


## Introduction

This plugin allows connectivity from Moodle to IADLearning adaptive e-learning solution.

IADLearning is a tool which supplements the LMS functionality and extends its capabilities to provide students a **personalized learning experience**.

IADLearning delivers:

- **Personalized content recommendations** targeting each individual student educational needs.
- **Rich analytics** to proactively act on ongoing learning processes.
- New content navigation schema based on **concept maps** showing the structure of the content as well as the relationships between the different content components

To learn more about IADLearning, visit www.iadlearning.com

## Release information

Current release of this plugin, delivers the following features:

- Connectivity to IADLearning
- Information about last connection performed to IADLearning
- Information about the tests completed within IADLearning
- Single sign on for students

## Plugin Installation

### Installation

Follow the steps below to perform the plugin install:

1. Download the zip file containing the plugin
2. Unzip the plugin zip file into the following directory <siteroot>/mod
3. Log into Moodle as administrator, the click 'Home'
4. Moodle will take. you the list of 'plugins requiring attention' (Plugins check)
5. IADLearning plugin will be listed as "To be installed'
6. Click on 'Upgrade Moodle database now'
7. The process will end up with the "Success" message
8. Click on "Continue" to proceed to the configuration screen (next section).


### Configuration

After the installation, you will be taken to the plugin configuration screen. 


If you want to ***activate IADLearning in demo mode***, leave the configuration empty and go to the "Demo configuration" section.


If you ***have your keys***, configure the plugin according to the information received from the IADLearning team.

1. Enter the following configuration settings:
 - **Back End Address**: URL of IADlearning backend instance to be used. For example: https://api.iadlearning.com
 - **Access Key ID**: ID of your IADlearning Key. For example: 2q3rq3rdcsczxDFGGJEL
 - **Secret Access Key**: Secret Key used to connect to IADLearning. For example: FGOIWfpjGJPOGJPOAJGPAEJGPOEG123RDF&

2. Click on 'Save changes'
 

If you need to ***change IADLearning configuration*** at any time:

1. Go to: Site administration -> Plugins -> Plugins overview 
2. Find IADlearning and click on 'Configure'

You are ready to use IADLearning!!



## Demo Configuration

1. Go to Site Administration > Plugins > Activity modules > IADLearning
2. Click on "Obtain Access Keys"
3. Fill in the request form
4. Click on save changes
5. Your demo keys will be generated
6. Click on "Save changes"
7. You will get an e-mail confirming your account together with your IADLearning access credentials. This credentials are only required when using IADLearning from outside Moodle.
8. Confirm your access by clicking on the link provided within the e-mail



## Plugin Use

IADLearning works as any other activity in Moodle.

In order to use it, follow the following steps:

1. Go to the Moodle Course where you want to add content from IADLearning
2. Enter 'Course Editing Mode'
3. Click on 'Add an activity or resource' on the section where the content needs to be added
4. Select 'IADLearning'
5. Provide a name for the activity
6. Go to IADLearning connection settings
7. Enter your IADLearning credentials email/pass and click on 'Load Courses'
8. All available courses will be shown: Select the one you want to link to this activity
9. Set whatever other settings are required
10. Click on 'Save and return to course'
11. Your activity should have been created



**NOTE**: In order to use IADLearning as a teacher or content creator, your should have IADLearning credentials. 

Get them from the IADLearning team by sending an email to info@iadlearning.com


**Users already enrolled at Moodle courses wont't require any login credentials to access IADLearning activities**


## Additional Information

In order to get additional information, contact info@iadlearning.com




