<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	global $wpdb;
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}

	$google_fonts = array(
							"Abel" => "Abel",
							"Abril Fatface" => "Abril Fatface",
							"Aclonica" => "Aclonica",
							"Acme" => "Acme",
							"Actor" => "Actor",
							"Adamina" => "Adamina",
							"Advent Pro" => "Advent Pro",
							"Aguafina Script" => "Aguafina Script",
							"Aladin" => "Aladin",
							"Aldrich" => "Aldrich",
							"Alegreya" => "Alegreya",
							"Alegreya SC" => "Alegreya SC",
							"Alex Brush" => "Alex Brush",
							"Alfa Slab One" => "Alfa Slab One",
							"Alice" => "Alice",
							"Alike" => "Alike",
							"Alike Angular" => "Alike Angular",
							"Allan" => "Allan",
							"Allerta" => "Allerta",
							"Allerta Stencil" => "Allerta Stencil",
							"Allura" => "Allura",
							"Almendra" => "Almendra",
							"Almendra SC" => "Almendra SC",
							"Amaranth" => "Amaranth",
							"Amatic SC" => "Amatic SC",
							"Amethysta" => "Amethysta",
							"Andada" => "Andada",
							"Andika" => "Andika",
							"Angkor" => "Angkor",
							"Annie Use Your Telescope" => "Annie Use Your Telescope",
							"Anonymous Pro" => "Anonymous Pro",
							"Antic" => "Antic",
							"Antic Didone" => "Antic Didone",
							"Antic Slab" => "Antic Slab",
							"Anton" => "Anton",
							"Arapey" => "Arapey",
							"Arbutus" => "Arbutus",
							"Architects Daughter" => "Architects Daughter",
							"Arimo" => "Arimo",
							"Arizonia" => "Arizonia",
							"Armata" => "Armata",
							"Artifika" => "Artifika",
							"Arvo" => "Arvo",
							"Asap" => "Asap",
							"Asset" => "Asset",
							"Astloch" => "Astloch",
							"Asul" => "Asul",
							"Atomic Age" => "Atomic Age",
							"Aubrey" => "Aubrey",
							"Audiowide" => "Audiowide",
							"Average" => "Average",
							"Averia Gruesa Libre" => "Averia Gruesa Libre",
							"Averia Libre" => "Averia Libre",
							"Averia Sans Libre" => "Averia Sans Libre",
							"Averia Serif Libre" => "Averia Serif Libre",
							"Bad Script" => "Bad Script",
							"Balthazar" => "Balthazar",
							"Bangers" => "Bangers",
							"Basic" => "Basic",
							"Battambang" => "Battambang",
							"Baumans" => "Baumans",
							"Bayon" => "Bayon",
							"Belgrano" => "Belgrano",
							"Belleza" => "Belleza",
							"Bentham" => "Bentham",
							"Berkshire Swash" => "Berkshire Swash",
							"Bevan" => "Bevan",
							"Bigshot One" => "Bigshot One",
							"Bilbo" => "Bilbo",
							"Bilbo Swash Caps" => "Bilbo Swash Caps",
							"Bitter" => "Bitter",
							"Black Ops One" => "Black Ops One",
							"Bokor" => "Bokor",
							"Bonbon" => "Bonbon",
							"Boogaloo" => "Boogaloo",
							"Bowlby One" => "Bowlby One",
							"Bowlby One SC" => "Bowlby One SC",
							"Brawler" => "Brawler",
							"Bree Serif" => "Bree Serif",
							"Bubblegum Sans" => "Bubblegum Sans",
							"Buda" => "Buda",
							"Buenard" => "Buenard",
							"Butcherman" => "Butcherman",
							"Butterfly Kids" => "Butterfly Kids",
							"Cabin" => "Cabin",
							"Cabin Condensed" => "Cabin Condensed",
							"Cabin Sketch" => "Cabin Sketch",
							"Caesar Dressing" => "Caesar Dressing",
							"Cagliostro" => "Cagliostro",
							"Calligraffitti" => "Calligraffitti",
							"Cambo" => "Cambo",
							"Candal" => "Candal",
							"Cantarell" => "Cantarell",
							"Cantata One" => "Cantata One",
							"Cardo" => "Cardo",
							"Carme" => "Carme",
							"Carter One" => "Carter One",
							"Caudex" => "Caudex",
							"Cedarville Cursive" => "Cedarville Cursive",
							"Ceviche One" => "Ceviche One",
							"Changa One" => "Changa One",
							"Chango" => "Chango",
							"Chau Philomene One" => "Chau Philomene One",
							"Chelsea Market" => "Chelsea Market",
							"Chenla" => "Chenla",
							"Cherry Cream Soda" => "Cherry Cream Soda",
							"Chewy" => "Chewy",
							"Chicle" => "Chicle",
							"Chivo" => "Chivo",
							"Coda" => "Coda",
							"Coda Caption" => "Coda Caption",
							"Codystar" => "Codystar",
							"Comfortaa" => "Comfortaa",
							"Coming Soon" => "Coming Soon",
							"Concert One" => "Concert One",
							"Condiment" => "Condiment",
							"Content" => "Content",
							"Contrail One" => "Contrail One",
							"Convergence" => "Convergence",
							"Cookie" => "Cookie",
							"Copse" => "Copse",
							"Corben" => "Corben",
							"Cousine" => "Cousine",
							"Coustard" => "Coustard",
							"Covered By Your Grace" => "Covered By Your Grace",
							"Crafty Girls" => "Crafty Girls",
							"Creepster" => "Creepster",
							"Crete Round" => "Crete Round",
							"Crimson Text" => "Crimson Text",
							"Crushed" => "Crushed",
							"Cuprum" => "Cuprum",
							"Cutive" => "Cutive",
							"Damion" => "Damion",
							"Dancing Script" => "Dancing Script",
							"Dangrek" => "Dangrek",
							"Dawning of a New Day" => "Dawning of a New Day",
							"Days One" => "Days One",
							"Delius" => "Delius",
							"Delius Swash Caps" => "Delius Swash Caps",
							"Delius Unicase" => "Delius Unicase",
							"Della Respira" => "Della Respira",
							"Devonshire" => "Devonshire",
							"Didact Gothic" => "Didact Gothic",
							"Diplomata" => "Diplomata",
							"Diplomata SC" => "Diplomata SC",
							"Doppio One" => "Doppio One",
							"Dorsa" => "Dorsa",
							"Dosis" => "Dosis",
							"Dr Sugiyama" => "Dr Sugiyama",
							"Droid Sans" => "Droid Sans",
							"Droid Sans Mono" => "Droid Sans Mono",
							"Droid Serif" => "Droid Serif",
							"Duru Sans" => "Duru Sans",
							"Dynalight" => "Dynalight",
							"EB Garamond" => "EB Garamond",
							"Eater" => "Eater",
							"Economica" => "Economica",
							"Electrolize" => "Electrolize",
							"Emblema One" => "Emblema One",
							"Emilys Candy" => "Emilys Candy",
							"Engagement" => "Engagement",
							"Enriqueta" => "Enriqueta",
							"Erica One" => "Erica One",
							"Esteban" => "Esteban",
							"Euphoria Script" => "Euphoria Script",
							"Ewert" => "Ewert",
							"Exo" => "Exo",
							"Expletus Sans" => "Expletus Sans",
							"Fanwood Text" => "Fanwood Text",
							"Fascinate" => "Fascinate",
							"Fascinate Inline" => "Fascinate Inline",
							"Federant" => "Federant",
							"Federo" => "Federo",
							"Felipa" => "Felipa",
							"Fjord One" => "Fjord One",
							"Flamenco" => "Flamenco",
							"Flavors" => "Flavors",
							"Fondamento" => "Fondamento",
							"Fontdiner Swanky" => "Fontdiner Swanky",
							"Forum" => "Forum",
							"Francois One" => "Francois One",
							"Fredericka the Great" => "Fredericka the Great",
							"Fredoka One" => "Fredoka One",
							"Freehand" => "Freehand",
							"Fresca" => "Fresca",
							"Frijole" => "Frijole",
							"Fugaz One" => "Fugaz One",
							"GFS Didot" => "GFS Didot",
							"GFS Neohellenic" => "GFS Neohellenic",
							"Galdeano" => "Galdeano",
							"Gentium Basic" => "Gentium Basic",
							"Gentium Book Basic" => "Gentium Book Basic",
							"Geo" => "Geo",
							"Geostar" => "Geostar",
							"Geostar Fill" => "Geostar Fill",
							"Germania One" => "Germania One",
							"Give You Glory" => "Give You Glory",
							"Glass Antiqua" => "Glass Antiqua",
							"Glegoo" => "Glegoo",
							"Gloria Hallelujah" => "Gloria Hallelujah",
							"Goblin One" => "Goblin One",
							"Gochi Hand" => "Gochi Hand",
							"Gorditas" => "Gorditas",
							"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
							"Graduate" => "Graduate",
							"Gravitas One" => "Gravitas One",
							"Great Vibes" => "Great Vibes",
							"Gruppo" => "Gruppo",
							"Gudea" => "Gudea",
							"Habibi" => "Habibi",
							"Hammersmith One" => "Hammersmith One",
							"Handlee" => "Handlee",
							"Hanuman" => "Hanuman",
							"Happy Monkey" => "Happy Monkey",
							"Henny Penny" => "Henny Penny",
							"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
							"Holtwood One SC" => "Holtwood One SC",
							"Homemade Apple" => "Homemade Apple",
							"Homenaje" => "Homenaje",
							"IM Fell DW Pica" => "IM Fell DW Pica",
							"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
							"IM Fell Double Pica" => "IM Fell Double Pica",
							"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
							"IM Fell English" => "IM Fell English",
							"IM Fell English SC" => "IM Fell English SC",
							"IM Fell French Canon" => "IM Fell French Canon",
							"IM Fell French Canon SC" => "IM Fell French Canon SC",
							"IM Fell Great Primer" => "IM Fell Great Primer",
							"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
							"Iceberg" => "Iceberg",
							"Iceland" => "Iceland",
							"Imprima" => "Imprima",
							"Inconsolata" => "Inconsolata",
							"Inder" => "Inder",
							"Indie Flower" => "Indie Flower",
							"Inika" => "Inika",
							"Irish Grover" => "Irish Grover",
							"Istok Web" => "Istok Web",
							"Italiana" => "Italiana",
							"Italianno" => "Italianno",
							"Jim Nightshade" => "Jim Nightshade",
							"Jockey One" => "Jockey One",
							"Jolly Lodger" => "Jolly Lodger",
							"Josefin Sans" => "Josefin Sans",
							"Josefin Slab" => "Josefin Slab",
							"Judson" => "Judson",
							"Julee" => "Julee",
							"Junge" => "Junge",
							"Jura" => "Jura",
							"Just Another Hand" => "Just Another Hand",
							"Just Me Again Down Here" => "Just Me Again Down Here",
							"Kameron" => "Kameron",
							"Karla" => "Karla",
							"Kaushan Script" => "Kaushan Script",
							"Kelly Slab" => "Kelly Slab",
							"Kenia" => "Kenia",
							"Khmer" => "Khmer",
							"Knewave" => "Knewave",
							"Kotta One" => "Kotta One",
							"Koulen" => "Koulen",
							"Kranky" => "Kranky",
							"Kreon" => "Kreon",
							"Kristi" => "Kristi",
							"Krona One" => "Krona One",
							"La Belle Aurore" => "La Belle Aurore",
							"Lancelot" => "Lancelot",
							"Lato" => "Lato",
							"League Script" => "League Script",
							"Leckerli One" => "Leckerli One",
							"Ledger" => "Ledger",
							"Lekton" => "Lekton",
							"Lemon" => "Lemon",
							"Lilita One" => "Lilita One",
							"Limelight" => "Limelight",
							"Linden Hill" => "Linden Hill",
							"Lobster" => "Lobster",
							"Lobster Two" => "Lobster Two",
							"Londrina Outline" => "Londrina Outline",
							"Londrina Shadow" => "Londrina Shadow",
							"Londrina Sketch" => "Londrina Sketch",
							"Londrina Solid" => "Londrina Solid",
							"Lora" => "Lora",
							"Love Ya Like A Sister" => "Love Ya Like A Sister",
							"Loved by the King" => "Loved by the King",
							"Lovers Quarrel" => "Lovers Quarrel",
							"Luckiest Guy" => "Luckiest Guy",
							"Lusitana" => "Lusitana",
							"Lustria" => "Lustria",
							"Macondo" => "Macondo",
							"Macondo Swash Caps" => "Macondo Swash Caps",
							"Magra" => "Magra",
							"Maiden Orange" => "Maiden Orange",
							"Mako" => "Mako",
							"Marck Script" => "Marck Script",
							"Marko One" => "Marko One",
							"Marmelad" => "Marmelad",
							"Marvel" => "Marvel",
							"Mate" => "Mate",
							"Mate SC" => "Mate SC",
							"Maven Pro" => "Maven Pro",
							"Meddon" => "Meddon",
							"MedievalSharp" => "MedievalSharp",
							"Medula One" => "Medula One",
							"Megrim" => "Megrim",
							"Merienda One" => "Merienda One",
							"Merriweather" => "Merriweather",
							"Metal" => "Metal",
							"Metamorphous" => "Metamorphous",
							"Metrophobic" => "Metrophobic",
							"Michroma" => "Michroma",
							"Miltonian" => "Miltonian",
							"Miltonian Tattoo" => "Miltonian Tattoo",
							"Miniver" => "Miniver",
							"Miss Fajardose" => "Miss Fajardose",
							"Modern Antiqua" => "Modern Antiqua",
							"Molengo" => "Molengo",
							"Monofett" => "Monofett",
							"Monoton" => "Monoton",
							"Monsieur La Doulaise" => "Monsieur La Doulaise",
							"Montaga" => "Montaga",
							"Montez" => "Montez",
							"Montserrat" => "Montserrat",
							"Moul" => "Moul",
							"Moulpali" => "Moulpali",
							"Mountains of Christmas" => "Mountains of Christmas",
							"Mr Bedfort" => "Mr Bedfort",
							"Mr Dafoe" => "Mr Dafoe",
							"Mr De Haviland" => "Mr De Haviland",
							"Mrs Saint Delafield" => "Mrs Saint Delafield",
							"Mrs Sheppards" => "Mrs Sheppards",
							"Muli" => "Muli",
							"Mystery Quest" => "Mystery Quest",
							"Neucha" => "Neucha",
							"Neuton" => "Neuton",
							"News Cycle" => "News Cycle",
							"Niconne" => "Niconne",
							"Nixie One" => "Nixie One",
							"Nobile" => "Nobile",
							"Nokora" => "Nokora",
							"Norican" => "Norican",
							"Nosifer" => "Nosifer",
							"Nothing You Could Do" => "Nothing You Could Do",
							"Noticia Text" => "Noticia Text",
							"Nova Cut" => "Nova Cut",
							"Nova Flat" => "Nova Flat",
							"Nova Mono" => "Nova Mono",
							"Nova Oval" => "Nova Oval",
							"Nova Round" => "Nova Round",
							"Nova Script" => "Nova Script",
							"Nova Slim" => "Nova Slim",
							"Nova Square" => "Nova Square",
							"Numans" => "Numans",
							"Nunito" => "Nunito",
							"Odor Mean Chey" => "Odor Mean Chey",
							"Old Standard TT" => "Old Standard TT",
							"Oldenburg" => "Oldenburg",
							"Oleo Script" => "Oleo Script",
							"Open Sans" => "Open Sans",
							"Open Sans Condensed" => "Open Sans Condensed",
							"Orbitron" => "Orbitron",
							"Original Surfer" => "Original Surfer",
							"Oswald" => "Oswald",
							"Over the Rainbow" => "Over the Rainbow",
							"Overlock" => "Overlock",
							"Overlock SC" => "Overlock SC",
							"Ovo" => "Ovo",
							"Oxygen" => "Oxygen",
							"PT Mono" => "PT Mono",
							"PT Sans" => "PT Sans",
							"PT Sans Caption" => "PT Sans Caption",
							"PT Sans Narrow" => "PT Sans Narrow",
							"PT Serif" => "PT Serif",
							"PT Serif Caption" => "PT Serif Caption",
							"Pacifico" => "Pacifico",
							"Parisienne" => "Parisienne",
							"Passero One" => "Passero One",
							"Passion One" => "Passion One",
							"Patrick Hand" => "Patrick Hand",
							"Patua One" => "Patua One",
							"Paytone One" => "Paytone One",
							"Permanent Marker" => "Permanent Marker",
							"Petrona" => "Petrona",
							"Philosopher" => "Philosopher",
							"Piedra" => "Piedra",
							"Pinyon Script" => "Pinyon Script",
							"Plaster" => "Plaster",
							"Play" => "Play",
							"Playball" => "Playball",
							"Playfair Display" => "Playfair Display",
							"Podkova" => "Podkova",
							"Poiret One" => "Poiret One",
							"Poller One" => "Poller One",
							"Poly" => "Poly",
							"Pompiere" => "Pompiere",
							"Pontano Sans" => "Pontano Sans",
							"Port Lligat Sans" => "Port Lligat Sans",
							"Port Lligat Slab" => "Port Lligat Slab",
							"Prata" => "Prata",
							"Preahvihear" => "Preahvihear",
							"Press Start 2P" => "Press Start 2P",
							"Princess Sofia" => "Princess Sofia",
							"Prociono" => "Prociono",
							"Prosto One" => "Prosto One",
							"Puritan" => "Puritan",
							"Quantico" => "Quantico",
							"Quattrocento" => "Quattrocento",
							"Quattrocento Sans" => "Quattrocento Sans",
							"Questrial" => "Questrial",
							"Quicksand" => "Quicksand",
							"Qwigley" => "Qwigley",
							"Radley" => "Radley",
							"Raleway" => "Raleway",
							"Rammetto One" => "Rammetto One",
							"Rancho" => "Rancho",
							"Rationale" => "Rationale",
							"Redressed" => "Redressed",
							"Reenie Beanie" => "Reenie Beanie",
							"Revalia" => "Revalia",
							"Ribeye" => "Ribeye",
							"Ribeye Marrow" => "Ribeye Marrow",
							"Righteous" => "Righteous",
							"Rochester" => "Rochester",
							"Rock Salt" => "Rock Salt",
							"Rokkitt" => "Rokkitt",
							"Ropa Sans" => "Ropa Sans",
							"Rosario" => "Rosario",
							"Rosarivo" => "Rosarivo",
							"Rouge Script" => "Rouge Script",
							"Ruda" => "Ruda",
							"Ruge Boogie" => "Ruge Boogie",
							"Ruluko" => "Ruluko",
							"Ruslan Display" => "Ruslan Display",
							"Russo One" => "Russo One",
							"Ruthie" => "Ruthie",
							"Sail" => "Sail",
							"Salsa" => "Salsa",
							"Sancreek" => "Sancreek",
							"Sansita One" => "Sansita One",
							"Sarina" => "Sarina",
							"Satisfy" => "Satisfy",
							"Schoolbell" => "Schoolbell",
							"Seaweed Script" => "Seaweed Script",
							"Sevillana" => "Sevillana",
							"Shadows Into Light" => "Shadows Into Light",
							"Shadows Into Light Two" => "Shadows Into Light Two",
							"Shanti" => "Shanti",
							"Share" => "Share",
							"Shojumaru" => "Shojumaru",
							"Short Stack" => "Short Stack",
							"Siemreap" => "Siemreap",
							"Sigmar One" => "Sigmar One",
							"Signika" => "Signika",
							"Signika Negative" => "Signika Negative",
							"Simonetta" => "Simonetta",
							"Sirin Stencil" => "Sirin Stencil",
							"Six Caps" => "Six Caps",
							"Slackey" => "Slackey",
							"Smokum" => "Smokum",
							"Smythe" => "Smythe",
							"Sniglet" => "Sniglet",
							"Snippet" => "Snippet",
							"Sofia" => "Sofia",
							"Sonsie One" => "Sonsie One",
							"Sorts Mill Goudy" => "Sorts Mill Goudy",
							"Special Elite" => "Special Elite",
							"Spicy Rice" => "Spicy Rice",
							"Spinnaker" => "Spinnaker",
							"Spirax" => "Spirax",
							"Squada One" => "Squada One",
							"Stardos Stencil" => "Stardos Stencil",
							"Stint Ultra Condensed" => "Stint Ultra Condensed",
							"Stint Ultra Expanded" => "Stint Ultra Expanded",
							"Stoke" => "Stoke",
							"Sue Ellen Francisco" => "Sue Ellen Francisco",
							"Sunshiney" => "Sunshiney",
							"Supermercado One" => "Supermercado One",
							"Suwannaphum" => "Suwannaphum",
							"Swanky and Moo Moo" => "Swanky and Moo Moo",
							"Syncopate" => "Syncopate",
							"Tangerine" => "Tangerine",
							"Taprom" => "Taprom",
							"Telex" => "Telex",
							"Tenor Sans" => "Tenor Sans",
							"The Girl Next Door" => "The Girl Next Door",
							"Tienne" => "Tienne",
							"Tinos" => "Tinos",
							"Titan One" => "Titan One",
							"Trade Winds" => "Trade Winds",
							"Trocchi" => "Trocchi",
							"Trochut" => "Trochut",
							"Trykker" => "Trykker",
							"Tulpen One" => "Tulpen One",
							"Ubuntu" => "Ubuntu",
							"Ubuntu Condensed" => "Ubuntu Condensed",
							"Ubuntu Mono" => "Ubuntu Mono",
							"Ultra" => "Ultra",
							"Uncial Antiqua" => "Uncial Antiqua",
							"UnifrakturCook" => "UnifrakturCook",
							"UnifrakturMaguntia" => "UnifrakturMaguntia",
							"Unkempt" => "Unkempt",
							"Unlock" => "Unlock",
							"Unna" => "Unna",
							"VT323" => "VT323",
							"Varela" => "Varela",
							"Varela Round" => "Varela Round",
							"Vast Shadow" => "Vast Shadow",
							"Vibur" => "Vibur",
							"Vidaloka" => "Vidaloka",
							"Viga" => "Viga",
							"Voces" => "Voces",
							"Volkhov" => "Volkhov",
							"Vollkorn" => "Vollkorn",
							"Voltaire" => "Voltaire",
							"Waiting for the Sunrise" => "Waiting for the Sunrise",
							"Wallpoet" => "Wallpoet",
							"Walter Turncoat" => "Walter Turncoat",
							"Wellfleet" => "Wellfleet",
							"Wire One" => "Wire One",
							"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
							"Yellowtail" => "Yellowtail",
							"Yeseva One" => "Yeseva One",
							"Yesteryear" => "Yesteryear",
							"Zeyada" => "Zeyada",
						);
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => "Basic",
						"type" => "heading");

	$options[] = array( "name" => "Responsiveness",
						"desc" => "",
						"id" => "responsiveness",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'On', 'no' => 'Off'));

	$options[] = array( "name" => "Favicon",
						"desc" => "",
						"id" => "favicon",
						"type" => "upload",
						"std" => "");

	$options[] = array( "name" => "Portfolio Items Per Page",
						"desc" => "",
						"id" => "portfolio_items",
						"std" => "10",
						"type" => "text");

	$options[] = array( "name" => "Copyright",
						"desc" => "",
						"id" => "copyright",
						"std" => 'Copyright 2012 Avada | All Rights Reserved | Powered by <a href="http://wordpress.org">WordPress</a>  |  <a href="http://theme-fusion.com">Theme Fusion</a>',
						"type" => "textarea");

	$options[] = array( "name" => "Analytics Code",
						"desc" => "Enter your analytics code, google or anything. It will be added before the </head> tag.",
						"id" => "analytics",
						"std" => '',
						"type" => "textarea");

	$options[] = array( "name" => "Feedburner Link",
						"desc" => "",
						"id" => "feedburner_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Show footer widgets?",
						"desc" => "",
						"id" => "footer_widgets",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show copyright footer?",
						"desc" => "",
						"id" => "footer_copyright",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Testimonials Slider Speed",
						"desc" => "1000 = 1 second",
						"id" => "testimonials_speed",
						"std" => "4000",
						"class" => "mini", //mini, tiny, small
						"type" => "text");

	$options[] = array( "name" => "Map Zoom Level",
						"desc" => "",
						"id" => "map_zoom",
						"std" => "8",
						"type" => "text");

	$options[] = array( "name" => "Blog Page Title",
						"desc" => "",
						"id" => "blog_title",
						"std" => "Blog",
						"type" => "text");

	$options[] = array( "name" => "Number of FlexSlider Slides",
						"desc" => "",
						"id" => "flexslider_slides",
						"std" => "5",
						"class" => "mini", //mini, tiny, small
						"type" => "text");

	$options[] = array( "name" => "Social",
						"type" => "heading");

	$options[] = array( "name" => "Facebook Link",
						"desc" => "",
						"id" => "facebook_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Twitter Link",
						"desc" => "",
						"id" => "twitter_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "LinkedIn Link",
						"desc" => "",
						"id" => "linkedin_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Dribbble Link",
						"desc" => "",
						"id" => "dribbble_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "RSS Link",
						"desc" => "",
						"id" => "rss_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Youtube Link",
						"desc" => "",
						"id" => "yt_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Pinterest Link",
						"desc" => "",
						"id" => "pint_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Custom Icon Name",
						"desc" => "Will be used on footer",
						"id" => "custom_icon_name",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Custom Icon Image Link",
						"desc" => "Will be used on footer",
						"id" => "custom_icon_image",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Custom Icon Link",
						"desc" => "Will be used on footer",
						"id" => "custom_icon_link",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Appearance",
						"type" => "heading");

	$options[] = array( "name" => "Logo",
						"desc" => "",
						"id" => "logo",
						"type" => "upload",
						"std" => get_bloginfo('template_directory') . "/images/logo.gif");


	$options[] = array( "name" => "Boxed or Wide Layout?",
						"desc" => "",
						"id" => "layout",
						"std" => "wide",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('boxed' => 'Boxed', 'wide' => 'Wide'));

	$options[] = array( "name" => "Background Pattern?",
						"desc" => "If yes, select the pattern from below:",
						"id" => "bg_pattern_option",
						"std" => "no",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('no' => 'No', 'yes' => 'Yes'));

	$options[] = array( "name" => "100% Background Image",
						"desc" => "If yes, the background image uploaded will always be 100% in width and height and scale according to the browser size.",
						"id" => "bg_full",
						"std" => "no",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('no' => 'No', 'yes' => 'Yes'));

	$options[] = array(
		'name' => "Select a Background Pattern",
		'desc' => "",
		'id' => "pattern",
		'std' => "pattern1",
		'type' => "images",
		'options' => array(
			'pattern1' => get_bloginfo('template_directory') . '/images/patterns/pattern1.png',
			'pattern2' => get_bloginfo('template_directory') . '/images/patterns/pattern2.png',
			'pattern3' => get_bloginfo('template_directory') . '/images/patterns/pattern3.png',
			'pattern4' => get_bloginfo('template_directory') . '/images/patterns/pattern4.png',
			'pattern5' => get_bloginfo('template_directory') . '/images/patterns/pattern5.png',
			'pattern6' => get_bloginfo('template_directory') . '/images/patterns/pattern6.png',
			'pattern7' => get_bloginfo('template_directory') . '/images/patterns/pattern7.png',
			'pattern8' => get_bloginfo('template_directory') . '/images/patterns/pattern8.png',
			'pattern9' => get_bloginfo('template_directory') . '/images/patterns/pattern9.png',
			'pattern10' => get_bloginfo('template_directory') . '/images/patterns/pattern10.png',
			)
	);

    $options[] = array( "name" => "Background Color",
					    "desc" => "",
					    "id" => "bg_color",
					    "std" => "#d7d6d6",
					    "type" => "color" );


	$options[] = array( "name" => "Background Image",
						"desc" => "",
						"id" => "background",
						"type" => "upload",
						"std" => "");

	$options[] = array( "name" => "Background Repeat",
						"desc" => "",
						"id" => "background_repeat",
						"std" => "repeat",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y'));

	$options[] = array( "name" => "Show page title bar?",
						"desc" => "",
						"id" => "page_title_bar",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Page Title Bar Background",
						"desc" => "",
						"id" => "page_title_bg",
						"type" => "upload",
						"std" => get_bloginfo('template_directory') . "/images/page_title_bg.png");

	$options[] = array( "name" => "Blog",
						"desc" => "",
						"id" => "blog_style",
						"std" => "large",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('large' => 'Blog Large Image', 'medium' => 'Blog Medium Image'));

	$options[] = array( "name" => "Blog Sidebar Position",
						"desc" => "",
						"id" => "sidebar_position",
						"std" => "right",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('right' => 'Right', 'left' => 'Left'));

	$options[] = array( "name" => "Body Copy Font",
						"desc" => "Select a google font",
						"id" => "body_font",
						"std" => "PT Sans",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $google_fonts);

	$google_fonts['museo'] = 'Museo Slab (requires font files, refer to documentation)';

	$options[] = array( "name" => "Headings Font",
						"desc" => "Select a google font",
						"id" => "headings_font",
						"std" => "Antic Slab",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $google_fonts);

	$options[] = array( "name" => "Image Rollovers",
						"desc" => "Enable or disable rollovers boxes on images",
						"id" => "image_rollover",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'On', 'no' => 'Off'));

	$options[] = array( "name" => "Post Images Slideshow",
						"desc" => "Enable or disable post images slideshow",
						"id" => "post_slideshow",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'On', 'no' => 'Off'));

	$options[] = array( "name" => "Number of Post Images Slideshow",
						"desc" => "",
						"id" => "posts_slideshow_count",
						"std" => "5",
						"class" => "mini", //mini, tiny, small
						"type" => "text");

	$options[] = array( "name" => "Design",
						"type" => "heading");

	$options[] = array(
	    "name" => "Color Scheme",
	    "desc" => "If you change the color scheme, your color options below will automatically update.",
	    "id" => "color_scheme",
	    "std" => "vibrant",
	    "type" => "select",
	    "options" => array('green' => 'Green', 'darkgreen' => 'Dark Green', 'yellow' => 'Yellow', 'lightblue' => 'Light Blue', 'lightred' => 'Light Red', 'pink' => 'Pink', 'lightgrey' => 'Light Grey', 'brown' => 'Brown', 'red' => 'Red', 'blue' => 'Blue'));

    $options[] = array( "name" => "Primary Color",
					    "desc" => "",
					    "id" => "primary_color",
					    "std" => "#a0ce4e",
					    "type" => "color" );

    $options[] = array( "name" => "Pricing Box Color",
					    "desc" => "",
					    "id" => "pricing_box_color",
					    "std" => "#92C563",
					    "type" => "color" );

    $options[] = array( "name" => "Image Rollover Gradient Color (Top)",
					    "desc" => "",
					    "id" => "image_gradient_top_color",
					    "std" => "#D1E990",
					    "type" => "color" );

    $options[] = array( "name" => "Image Rollover Gradient Color (Bottom)",
					    "desc" => "",
					    "id" => "image_gradient_bottom_color",
					    "std" => "#AAD75B",
					    "type" => "color" );


    $options[] = array( "name" => "Button Gradient Color (Top)",
					    "desc" => "",
					    "id" => "button_gradient_top_color",
					    "std" => "#D1E990",
					    "type" => "color" );

    $options[] = array( "name" => "Button Gradient Color (Bottom)",
					    "desc" => "",
					    "id" => "button_gradient_bottom_color",
					    "std" => "#AAD75B",
					    "type" => "color" );

    $options[] = array( "name" => "Button Text Color (Bottom)",
					    "desc" => "",
					    "id" => "button_gradient_text_color",
					    "std" => "#54770f",
					    "type" => "color" );

	$options[] = array( "name" => "Custom CSS",
						"desc" => "",
						"id" => "custom_css",
						"std" => '',
						"type" => "textarea");

	$options[] = array( "name" => "Content",
						"type" => "heading");

	$options[] = array( "name" => "Add read more link after post excerpt?",
						"desc" => "",
						"id" => "read_more",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show post meta box?",
						"desc" => "",
						"id" => "post_meta",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show post author box?",
						"desc" => "",
						"id" => "post_author_box",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show share box?",
						"desc" => "",
						"id" => "share_box",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show related posts?",
						"desc" => "",
						"id" => "related_posts",
						"std" => "yes",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('yes' => 'Yes', 'no' => 'No'));

	$options[] = array( "name" => "Show comments?",
						"desc" => "",
						"id" => "comments",
						"std" => "enable",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array('enable' => 'Enable', 'disable' => 'Disable'));

	return $options;
}