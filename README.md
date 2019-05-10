Upload to File Resource Local Plugin for Moodle 2.2+
==================================================

This is a package to upload File Resource in Moodle via webservice API.

Installation
-----------------

To install the plugin using git, execute the following commands in the root of your Moodle install:

    git clone https://github.com/GuillaumeBlin/moodle-local_uploadpdf.git your_moodle_root/local/uploadpdf
    
Or, extract the following zip in `your_moodle_root/local/` as follows:

    cd your_moodle_root/local/
    wget https://github.com/GuillaumeBlin/moodle-local_uploadpdf/archive/master.zip
    unzip -j master.zip -d uploadpdf
    
Configuration
-----------------

To make the webservice available, go to Site administration / Plugins / Web services / External services

In Built-in service, allow the uploadpdf service using "uploadpdf" as shortname

In Manage tokens, add a token for the ws user for the Uploadpdf service

