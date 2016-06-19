	
	CREATE TABLE MJV_ID_PROOFS (
		
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) NOT NULL,		
		
		PRIMARY KEY (id)
	);
    		
	CREATE TABLE MJV_USER_PROFILE (
		
		id INT NOT NULL AUTO_INCREMENT,
		first_name VARCHAR(64) NOT NULL,
		last_name VARCHAR(64) NOT NULL,
		email VARCHAR(64) NOT NULL,
		id_proof_type SMALLINT NOT NULL,
		id_proof_name VARCHAR(64) NOT NULL,
		id_proof_value VARCHAR(64) NOT NULL,
		profession VARCHAR(64) NOT NULL,
		profile_pic_path VARCHAR(64),
		contact_number VARCHAR(64) NOT NULL,
		
		PRIMARY KEY (id),
		INDEX (id_proof_type),
		FOREIGN KEY (id_proof_type)
		  REFERENCES MJV_ID_PROOFS(id)
		  ON UPDATE CASCADE ON DELETE RESTRICT
	);
	
	CREATE TABLE MJV_USERS (		
		
		user_email VARCHAR(64) NOT NULL,
		password VARCHAR(64) NOT NULL,
		user_id INT NOT NULL,
		
		PRIMARY KEY (user_id),
		INDEX (user_id),
		
		FOREIGN KEY (user_id)
		  REFERENCES MJV_USER_PROFILE(id)
		  ON UPDATE CASCADE ON DELETE RESTRICT
		
	);
	
	CREATE TABLE MJV_PORTAL_TYPE (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) NOT NULL,
		display_order SMALLINT,
		created_date DATETIME NOT NULL,
		last_updated_date DATETIME NOT NULL,
		
		PRIMARY KEY(id)
	);
	
	
	CREATE TABLE MJV_USER_CONTRIBUTIONS (
		
		user_id INT NOT NULL,
		portal_type	SMALLINT NOT NULL,
		
		
		PRIMARY KEY (user_id,portal_type),
		INDEX (user_id),
		INDEX (portal_type),

		FOREIGN KEY (user_id)
		  REFERENCES MJV_USER_PROFILE(id)
		  ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (portal_type)
		  REFERENCES MJV_PORTAL_TYPE(id)
		  ON UPDATE CASCADE ON DELETE RESTRICT
	);

	CREATE TABLE MJV_USER_ROLE (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(20) NOT NULL,
		description VARCHAR(255),
		
		PRIMARY KEY(id)

	);

	CREATE TABLE MJV_USER_TO_ROLE (
		user_id INT NOT NULL,
		role_id SMALLINT NOT NULL,
		
		PRIMARY KEY(user_id, role_id),
		INDEX(user_id),
		INDEX(role_id),
		
		FOREIGN KEY (user_id)
			REFERENCES MJV_USER_PROFILE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
			
		FOREIGN KEY (role_id) 
			REFERENCES MJV_USER_ROLE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT

	);

	CREATE TABLE MJV_GALLERY (
		name VARCHAR(64) NOT NULL,
		physical_path VARCHAR(255) NOT NULL,
		
		PRIMARY KEY (name, physical_path)
	);

	CREATE TABLE MJV_SERVICE_REQUEST_SEVERITY (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(20) NOT NULL,
		
		PRIMARY KEY(id)
	);

	CREATE TABLE MJV_SERVICE_REQUEST_PRIORITY (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(20) NOT NULL,
		
		PRIMARY KEY(id)
	);

	CREATE TABLE MJV_SERVICE_REQUEST_STATUS (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(20) NOT NULL,
		
		PRIMARY KEY(id)
	);
	

	CREATE TABLE MJV_PORTAL_SUB_TYPE (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) NOT NULL,
 		portal_type SMALLINT NOT NULL,
		created_date DATETIME NOT NULL,
		last_updated_date DATETIME NOT NULL,
		
		PRIMARY KEY(id),
		INDEX(portal_type),
		
		FOREIGN KEY(portal_type) 
				REFERENCES MJV_PORTAL_TYPE(id)
				ON UPDATE CASCADE ON DELETE RESTRICT
		
	);


	CREATE TABLE MJV_SERVICE_REQUEST (

		id INT NOT NULL AUTO_INCREMENT,
		subject VARCHAR(64) NOT NULL,
		description TEXT NOT NULL,
		created_date DATETIME NOT NULL,
		last_updated_date DATETIME NOT NULL,
		severity SMALLINT NOT NULL,
		priority SMALLINT NOT NULL,
		status SMALLINT NOT NULL,
		service_type SMALLINT NOT NULL,
		submitted_by_user_id INT NOT NULL,
		assigned_to_user_id INT NOT NULL,
		approver_user_id INT NOT NULL,
		attachments BLOB,
		comments VARCHAR(255),
		
		PRIMARY KEY(id),
		INDEX(severity),
		INDEX(status),
		INDEX(priority),
		INDEX(service_type),
		INDEX(submitted_by_user_id),
		INDEX(assigned_to_user_id),
		INDEX(approver_user_id),
		
		FOREIGN KEY (severity)
			REFERENCES MJV_SERVICE_REQUEST_SEVERITY(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
			
		FOREIGN KEY (status) 
			REFERENCES MJV_SERVICE_REQUEST_STATUS(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (priority)
			REFERENCES MJV_SERVICE_REQUEST_PRIORITY(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
			
		FOREIGN KEY (service_type) 
			REFERENCES MJV_PORTAL_SUB_TYPE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (submitted_by_user_id)
			REFERENCES MJV_USER_PROFILE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (submitted_by_user_id)
			REFERENCES MJV_USER_PROFILE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (approver_user_id)
			REFERENCES MJV_USER_PROFILE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT
		
	);

	CREATE TABLE MJV_ARTICLE_STATUS (
		id SMALLINT NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) NOT NULL,

		PRIMARY KEY(id)
	);


	CREATE TABLE MJV_ARTICLE (
		id INT NOT NULL AUTO_INCREMENT,
		portal_type SMALLINT NOT NULL,
		service_type SMALLINT NOT NULL,
		created_date DATE NOT NULL,
		last_updated_date DATE NOT NULL,
		status SMALLINT NOT NULL,
		content MEDIUMBLOB NOT NULL,
		
		PRIMARY KEY(id),
		INDEX(portal_type),
		INDEX(service_type),
		INDEX(status), 
		
		FOREIGN KEY (portal_type) 
			REFERENCES MJV_PORTAL_TYPE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
				
		FOREIGN KEY (service_type) 
			REFERENCES MJV_PORTAL_SUB_TYPE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT,
		
		FOREIGN KEY (status) 
			REFERENCES MJV_ARTICLE_STATUS(id)
			ON UPDATE CASCADE ON DELETE RESTRICT		

	);

	CREATE TABLE MJV_ANNOUNCEMENTS (
		id INT NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) NOT NULL,
		public char(1) NOT NULL,
		
		PRIMARY KEY(id)
	);


	CREATE TABLE MJV_CMD (
		id INT NOT NULL AUTO_INCREMENT,
		content MEDIUMBLOB NOT NULL,
		
		PRIMARY KEY(id)
	);


	CREATE TABLE MJV_TOKEN (
		user_id INT NOT NULL,
		token_string VARCHAR(64) NOT NULL,
		
		PRIMARY KEY(user_id, token_string),
		FOREIGN KEY (user_id) 
			REFERENCES MJV_USER_PROFILE(id)
			ON UPDATE CASCADE ON DELETE RESTRICT
	);
	
	INSERT INTO MJV_USER_ROLE (name, description) VALUES("admin", "Can add new tabs and key services in knowledge portal, edit, delete existing content, approve or reject service requests submitted by volunteers, review and publish the contents"), ("volunteer", "create a service request, update and delete service requests raised by self and submit content for knowledge portal");
	
	INSERT INTO MJV_SERVICE_REQUEST_SEVERITY (name) VALUES ("Minor"), ("Medium"), ("Critical");
	
	INSERT INTO MJV_SERVICE_REQUEST_PRIORITY (name) VALUES ("Low"), ("Medium"), ("High");
	
	INSERT INTO MJV_SERVICE_REQUEST_STATUS (name) VALUES ("open"), ("In Progress"), ("Closed"), ("Force Closed");
	
	INSERT INTO MJV_ARTICLE_STATUS (name) VALUES ("Yet to be reviewed"), ("Closed by self"), ("Rejected"),("Published");
	
	INSERT INTO MJV_PORTAL_TYPE (name, display_order, created_date, last_updated_date) VALUES ("General Updates", 1, NOW(), NOW()),  
																							   ("Health & Welfare", 2, NOW(), NOW()), 
																							   ("Career & Education", 3, NOW(), NOW()), 
																							   ("Social & Security", 4, NOW(), NOW()),
																							   ("Art & Culture", 5, NOW(), NOW()),
																							   ("Women welfare", 6, NOW(), NOW());
		
	INSERT INTO MJV_PORTAL_SUB_TYPE (name, portal_type, created_date, last_updated_date) VALUES 	   
					("Medical counselling", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE 	name = 'Health & Welfare') , NOW(), NOW()),  
					("Doctor appointment", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Health & Welfare'), NOW(), NOW()), 
					("Blood donation", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Health & Welfare'), NOW(), NOW()),
					("Sponsor funds for health recovery", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Health & Welfare'), NOW(), NOW()),
					("Health camps", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Health & Welfare'), NOW(), NOW()),
					("Medical awarness programs", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Health & Welfare'), NOW(), NOW());
	
	INSERT INTO MJV_PORTAL_SUB_TYPE(name, portal_type, created_date, last_updated_date) VALUES 	   
					("Career guidance", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Career & Education') , NOW(), NOW()),  
					("Job opportunities", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Career & Education'), NOW(), NOW()), 
					("Job references", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Career & Education'), NOW(), NOW()),
					("Online trainings", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Career & Education'), NOW(), NOW()),
					("Education sponsorship", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Career & Education'), NOW(), NOW());
					
	INSERT INTO MJV_PORTAL_SUB_TYPE(name, portal_type, created_date, last_updated_date) VALUES 	   
					("Medical counselling", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Social & Security') , NOW(), NOW()),  
					("Doctor appointment", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Social & Security'), NOW(), NOW()), 
					("Blood donation", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Social & Security'), NOW(), NOW());
					
	INSERT INTO MJV_PORTAL_SUB_TYPE(name, portal_type, created_date, last_updated_date) VALUES 	   
					("Art related carnivals", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Art & Culture') , NOW(), NOW()),  
					("Music", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Art & Culture'), NOW(), NOW()), 
					("Dance festival", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Art & Culture'), NOW(), NOW()),
					("Competitions", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Art & Culture'), NOW(), NOW()),
					("References for the training institutes", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Art & Culture'), NOW(), NOW());
					
	INSERT INTO MJV_PORTAL_SUB_TYPE(name, portal_type, created_date, last_updated_date) VALUES 	   
					("Women specific job opportunities", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Women welfare') , NOW(), NOW()),  
					("Trainings on self employment,", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Women welfare'), NOW(), NOW()), 
					("Women safety", (SELECT DISTINCT id FROM MJV_PORTAL_TYPE WHERE name = 'Women welfare'), NOW(), NOW()); 	
	
	INSERT INTO MJV_ID_PROOFS(name) VALUES 	   
					("Aadhar Card"),  
					("Electoral Id"), 
					("Pan Card"),
					("Passport"),
					("Driving License"),
					("Others");
	
	