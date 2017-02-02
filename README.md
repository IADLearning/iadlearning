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
- Single sign on for students (do not require any account creation within IADLearning)

## Plugin Installation


### Installation

1. Download the zip file containing the plugin
2. Unzip the plugin zip file into the following directory /siteroot/mod
3. Log into Moodle as administrator, the click 'Home'
4. Moodle will take you to the list of plugins requiring your attention
5. Click on 'Upgrade Moodle database now'
6. After installation, Moodle will take you to the configuration screen


### Configuration

After the installation, you will be taken to the plugin configuration screen. Configure the plugin according to the information received from IADLearning Team.

 - **Front End Address**: URL of IADLearning Front End instance to be used. For example: demo.iadlearning.com (do not include http/https)
 - **Front End Connection Port**: Port to be used to connect to your IADLearning instance.  For example: 80
 - **Back End Address**: URL of IADLearning Back End backend instance to be used. For example: api.iadlearning.com (do not include http/https)
 - **Back End Connection Port**:  Port to be used to connect to IADLearning backend.  For example: 3000
 - **Access Key ID**: ID of your IADLearning Access Key. For example: 2q3rq3rdcsczxDFGGJEL
 - **Secret Access Key**: Secret Key used to connect to IADLearning. For example: FGOIWfpjGJPOGJPOAJGPAEJGPOEG123RDF&

 Click on 'Save changes'

If you need to change IADLearning configuration at any time later, go to: Site administration -> Plugins -> Plugins overview, locate IADLearning and click on 'Configure'

You are ready to use IADLearning!!


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


## Access Credentials

In order to use IADLearning as a teacher or content creator, your should have IADLearning credentials. 

Get them from the IADLearning team by sending an email to info@iadlearning.com


**Users already enrolled at Moodle courses wont't require any login credentials to access IADLearning activities**


## Additional Information

To get additional information, contact info@iadlearning.com




