
# GroceryMart

## This is project for Online Grocery Shopping System

## A project based on Symfony 5.2

Steps For Running And Configure The Project:

	1. Installation

		1.Download Symfony 5.2 From: https://symfony.com/download/ And Install It
  
		2.Download Composer From: https://getcomposer.org/download/ And Install It
	
	2. Clone or download repository

		git clone https://github.com/parth1601/grocery-mart.git
		cd grocery-mart/
		composer install
			
					or
				
	2. Check Requirements And Create Project

		The Symfony Binary Also Provides A Tool To Check If Your Computer Meets All Requirements. Open your console terminal and run this command:
		
			symfony check:requirements
			
		To Create A Project Open your console terminal and run this command:
		
			composer create-project symfony/website-skeleton GroceryMart
			
						or
						
			symfony new GroceryMart --full
			
		Note: Before Running The Project Download This Directories config,public,src & templet From https://github.com/parth1601/grocery-mart 
		      And Replace It With Your Directories.

	3. Install Bundles Using This Commands:
		
		1. EasyAdmin Bundle:
			
			composer require easycorp/easyadmin-bundle
		
		2. PhpSpreadsheet Bundle:
			
			composer require phpoffice/phpspreadsheet
		
		3. FileSystem Bundle:
			
			composer require symfony/filesystem

		4. Verify Email Bundle:

			composer require symfonycasts/verify-email-bundle

		5. vich Bundle:

			composer require vich/uploader-bundle

		6. Apache-pack Bundle:

			composer require symfony/apache-pack
				
	4. Clear Cache:
		
		php bin/console cache:clear

	5. Run Server/Project:
		
		symfony server:start
		
	6. Browse 
		
		1. User Interface:

			Home Page: https://127.0.0.1:8000/
			
		3. Admin Interface:

			Dashboard: https://127.0.0.1:8000/admin
			
	7. Stop Server/Project:
	 
		symfony server:stop
