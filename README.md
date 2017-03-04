# Default Term (FOR DEVELOPERS ONLY)
WordPress Plugin that allows you to set a default term of a taxonomy

## Usage

1. Install plugin download [here](https://github.com/allanchristiancarlos/default-term/archive/master.zip)
2. Add a **default_term** key in your registration of taxonomy. 
3. (IMPORTANT) Then **DEACTIVATE** and **ACTIVATE** plugin to save the default term into the database.

```
register_taxonomy( 'custom-tax', ['post'], [
		'label'              => 'Custom Tag',
		'public'             => true,
		'show_ui'            => true,
		'default_term'       => 'Uncategorized',
	]);
```

## Whats in it
* Saves the default term to the post
* Removes the delete link and checkbox in the terms list


## Options

```
register_taxonomy( 'custom-tax', ['post'], [
		'label'              => 'Custom Tag',
		'public'             => true,
		'show_ui'            => true,
		'default_term'       => 'Uncategorized',
		'default_term_slug'       => 'slug',
		'default_term_force'       => false
	]);
```

**default_term** (REQUIRED, STRING)
  
  - The default term name
  
**default_term_slug** (OPTIONAL, STRING)
  
  - Custom slug of the default term
  
**default_term_force** (OPTIONAL, BOOLEAN)

  - Whether to force the default term even the user unchecks or unselected the default term. Defaults to **true**
  
## Notes
* Everytime you change a default term you need to deactivate and activate the plugin to save the terms to the database.

## TODO
* Add a backend UI for setting the default taxonomy term
