OpenEdition Journale Editorial Model upgrade scripts 
===========================================================================


This directory contains php scripts that update editorial model from a version to the next one.

Install

- copy or make a symbolic link of the file in the root directory of the Lodel install

Execute

.. code-block:: sh

   cd PATH_TO_ROOT_LODEL_DIRECTORY
   php upgrade_X.X.X_to_Y.Y.Y.php mysite # update the site "mysite"
   # or 
   php upgrade_X.X.X_to_Y.Y.Y.php all # update all sites (excepted site listed in the array $exclude definied in the php file)

- after execution, file should be remove from lodel root directory

- edit upgrade_X.X.X_to_Y.Y.Y.php for details
