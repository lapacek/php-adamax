.PHONY: all test

test_db_sqlite_file="Test/Application/Database/Test.sqlite"
test_db_bin_file="Test/Application/Database/Test.db"
phpunit_config="Test/phpunit.xml"

test:
	@echo
	@echo "Loading test database."

	@if [ -f ${test_db_bin_file} ] ; then \
		rm ${test_db_bin_file} ; \
	fi
	
	@if [ ! -f ${test_db_sqlite_file} ] ; then \
		echo "File: " ${test_db_sqlite_file} " don\`t exists." ; \
		exit ; \
	fi

	@sqlite3 ${test_db_bin_file} < ${test_db_sqlite_file}

	@echo "Starting tests."
	@phpunit -c ${phpunit_config} 
