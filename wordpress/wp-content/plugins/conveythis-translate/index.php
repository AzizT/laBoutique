<?php
/*
Plugin Name: ConveyThis Translate
Plugin URI: https://www.conveythis.com/?utm_source=widget&utm_medium=wordpress
Description: Translate your WordPress site into over 100 languages using professional and instant machine translation technology. ConveyThis will help provide you with an SEO-friendy, multilingual website in minutes with no coding required.
Version: 55
Author: ConveyThis Translate Team
Author URI: https://www.conveythis.com/?utm_source=widget&utm_medium=wordpress
Text Domain: conveythis-translate
License: GPL2
*/

//for debuging:	
//file_put_contents(ABSPATH.'/tmp/test_txt.txt', "some text\n", FILE_APPEND);

if( !defined( 'ABSPATH' ) )
{
    exit;
}

define( 'CONVEYTHIS_JAVASCRIPT_PLUGIN_URL', '//cdn.conveythis.com/javascript/33' );
define( 'CONVEYTHIS_API_URL', 'https://api.conveythis.com/25' );

class ConveyThis
{
	static $instance;

	var $segments = array();
	var $account;
	var $api_key = '';
	var $source_language = '';
	var $target_languages = '';
	var $language_code = '';
	var $site_url;
	var $site_prefix;

	// Luxemb - Luxembourgish
	// Haitian - Haitian (Creole)
		
	var $languages = array(
		703 => array( 'language_id' => 703, 'title' => 'English', 'code2' => 'en', 'code3' => 'eng', 'flag' => 'Dw0' ),
		704 => array( 'language_id' => 704, 'title' => 'Afrikaans', 'code2' => 'af', 'code3' => 'afr', 'flag' => '7xS' ),
		705 => array( 'language_id' => 705, 'title' => 'Albanian', 'code2' => 'sq', 'code3' => 'sqi', 'flag' => '5iM' ),
		706 => array( 'language_id' => 706, 'title' => 'Amharic', 'code2' => 'am', 'code3' => 'amh', 'flag' => 'ZH1' ),
		707 => array( 'language_id' => 707, 'title' => 'Arabic', 'code2' => 'ar', 'code3' => 'ara', 'flag' => 'J06' ),
		708 => array( 'language_id' => 708, 'title' => 'Armenian', 'code2' => 'hy', 'code3' => 'hye', 'flag' => 'q9U' ),
		709 => array( 'language_id' => 709, 'title' => 'Azerbaijan', 'code2' => 'az', 'code3' => 'aze', 'flag' => 'Wg1' ),
		710 => array( 'language_id' => 710, 'title' => 'Bashkir', 'code2' => 'ba', 'code3' => 'bak', 'flag' => 'D1H' ),
		711 => array( 'language_id' => 711, 'title' => 'Basque', 'code2' => 'eu', 'code3' => 'eus', 'flag' => 'none' ),
		712 => array( 'language_id' => 712, 'title' => 'Belarusian', 'code2' => 'be', 'code3' => 'bel', 'flag' => 'O8S' ),
		713 => array( 'language_id' => 713, 'title' => 'Bengali', 'code2' => 'bn', 'code3' => 'ben', 'flag' => '63A' ),
		714 => array( 'language_id' => 714, 'title' => 'Bosnian', 'code2' => 'bs', 'code3' => 'bos', 'flag' => 'Z1t' ),
		715 => array( 'language_id' => 715, 'title' => 'Bulgarian', 'code2' => 'bg', 'code3' => 'bul', 'flag' => 'V3p' ),
		716 => array( 'language_id' => 716, 'title' => 'Burmese', 'code2' => 'my', 'code3' => 'mya', 'flag' => 'YB9' ),
		717 => array( 'language_id' => 717, 'title' => 'Catalan', 'code2' => 'ca', 'code3' => 'cat', 'flag' => 'Pw6' ),
		718 => array( 'language_id' => 718, 'title' => 'Cebuano', 'code2' => 'ceb', 'code3' => 'ceb', 'flag' => 'none' ),
		719 => array( 'language_id' => 719, 'title' => 'Chinese', 'code2' => 'zh', 'code3' => 'zho', 'flag' => 'Z1v' ),
		720 => array( 'language_id' => 720, 'title' => 'Croatian', 'code2' => 'hr', 'code3' => 'hrv', 'flag' => '7KQ' ),
		721 => array( 'language_id' => 721, 'title' => 'Czech', 'code2' => 'cs', 'code3' => 'cze', 'flag' => '1ZY' ),
		722 => array( 'language_id' => 722, 'title' => 'Danish', 'code2' => 'da', 'code3' => 'dan', 'flag' => 'Ro2' ),
		723 => array( 'language_id' => 723, 'title' => 'Dutch', 'code2' => 'nl', 'code3' => 'nld', 'flag' => '8jV' ),
		724 => array( 'language_id' => 724, 'title' => 'Esperanto', 'code2' => 'eo', 'code3' => 'epo', 'flag' => 'Dw0' ),
		725 => array( 'language_id' => 725, 'title' => 'Estonian', 'code2' => 'et', 'code3' => 'est', 'flag' => 'VJ8' ),
		726 => array( 'language_id' => 726, 'title' => 'Finnish', 'code2' => 'fi', 'code3' => 'fin', 'flag' => 'nM4' ),
		727 => array( 'language_id' => 727, 'title' => 'French', 'code2' => 'fr', 'code3' => 'fre', 'flag' => 'E77' ),
		728 => array( 'language_id' => 728, 'title' => 'Galician', 'code2' => 'gl', 'code3' => 'glg', 'flag' => 'A5d' ),
		729 => array( 'language_id' => 729, 'title' => 'Georgian', 'code2' => 'ka', 'code3' => 'kat', 'flag' => '8Ou' ),
		730 => array( 'language_id' => 730, 'title' => 'German', 'code2' => 'de', 'code3' => 'ger', 'flag' => 'K7e' ),
		731 => array( 'language_id' => 731, 'title' => 'Greek', 'code2' => 'el', 'code3' => 'ell', 'flag' => 'kY8' ),
		732 => array( 'language_id' => 732, 'title' => 'Gujarati', 'code2' => 'gu', 'code3' => 'guj', 'flag' => 'My6' ),
		733 => array( 'language_id' => 733, 'title' => 'Haitian', 'code2' => 'ht', 'code3' => 'hat', 'flag' => 'none' ),
		734 => array( 'language_id' => 734, 'title' => 'Hebrew', 'code2' => 'he', 'code3' => 'heb', 'flag' => '5KS' ),
		735 => array( 'language_id' => 735, 'title' => 'Hill Mari', 'code2' => 'mrj', 'code3' => 'mrj', 'flag' => 'none' ),
		736 => array( 'language_id' => 736, 'title' => 'Hindi', 'code2' => 'hi', 'code3' => 'hin', 'flag' => 'My6' ),
		737 => array( 'language_id' => 737, 'title' => 'Hungarian', 'code2' => 'hu', 'code3' => 'hun', 'flag' => 'OU2' ),
		738 => array( 'language_id' => 738, 'title' => 'Icelandic', 'code2' => 'is', 'code3' => 'isl', 'flag' => 'Ho8' ),
		739 => array( 'language_id' => 739, 'title' => 'Indonesian', 'code2' => 'id', 'code3' => 'ind', 'flag' => 't0X' ),
		740 => array( 'language_id' => 740, 'title' => 'Irish', 'code2' => 'ga', 'code3' => 'gle', 'flag' => '5Tr' ),
		741 => array( 'language_id' => 741, 'title' => 'Italian', 'code2' => 'it', 'code3' => 'ita', 'flag' => 'BW7' ),
		742 => array( 'language_id' => 742, 'title' => 'Japanese', 'code2' => 'ja', 'code3' => 'jpn', 'flag' => '4YX' ),
		743 => array( 'language_id' => 743, 'title' => 'Javanese', 'code2' => 'jv', 'code3' => 'jav', 'flag' => 'C9k' ),
		744 => array( 'language_id' => 744, 'title' => 'Kannada', 'code2' => 'kn', 'code3' => 'kan', 'flag' => 'My6' ),
		745 => array( 'language_id' => 745, 'title' => 'Kazakh', 'code2' => 'kk', 'code3' => 'kaz', 'flag' => 'QA5' ),
		746 => array( 'language_id' => 746, 'title' => 'Khmer', 'code2' => 'km', 'code3' => 'khm', 'flag' => 'o8B' ),
		747 => array( 'language_id' => 747, 'title' => 'Korean', 'code2' => 'ko', 'code3' => 'kor', 'flag' => '0W3' ),
		748 => array( 'language_id' => 748, 'title' => 'Kyrgyz', 'code2' => 'ky', 'code3' => 'kir', 'flag' => 'uP6' ),
		749 => array( 'language_id' => 749, 'title' => 'Laotian', 'code2' => 'lo', 'code3' => 'lao', 'flag' => 'Qy5' ),
		750 => array( 'language_id' => 750, 'title' => 'Latin', 'code2' => 'la', 'code3' => 'lat', 'flag' => 'BW7' ),
		751 => array( 'language_id' => 751, 'title' => 'Latvian', 'code2' => 'lv', 'code3' => 'lav', 'flag' => 'j1D' ),
		752 => array( 'language_id' => 752, 'title' => 'Lithuanian', 'code2' => 'lt', 'code3' => 'lit', 'flag' => 'uI6' ),
		753 => array( 'language_id' => 753, 'title' => 'Luxemb', 'code2' => 'lb', 'code3' => 'ltz', 'flag' => 'EV8' ),
		754 => array( 'language_id' => 754, 'title' => 'Macedonian', 'code2' => 'mk', 'code3' => 'mkd', 'flag' => '6GV' ),
		755 => array( 'language_id' => 755, 'title' => 'Malagasy', 'code2' => 'mg', 'code3' => 'mlg', 'flag' => '4tE' ),
		756 => array( 'language_id' => 756, 'title' => 'Malay', 'code2' => 'ms', 'code3' => 'msa', 'flag' => 'C9k' ),
		757 => array( 'language_id' => 757, 'title' => 'Malayalam', 'code2' => 'ml', 'code3' => 'mal', 'flag' => 'My6' ),
		758 => array( 'language_id' => 758, 'title' => 'Maltese', 'code2' => 'mt', 'code3' => 'mlt', 'flag' => 'N11' ),
		759 => array( 'language_id' => 759, 'title' => 'Maori', 'code2' => 'mi', 'code3' => 'mri', 'flag' => '0Mi' ),
		760 => array( 'language_id' => 760, 'title' => 'Marathi', 'code2' => 'mr', 'code3' => 'mar', 'flag' => 'My6' ),
		761 => array( 'language_id' => 761, 'title' => 'Mari', 'code2' => 'mhr', 'code3' => 'chm', 'flag' => 'none' ),
		762 => array( 'language_id' => 762, 'title' => 'Mongolian', 'code2' => 'mn', 'code3' => 'mon', 'flag' => 'X8h' ),
		763 => array( 'language_id' => 763, 'title' => 'Nepali', 'code2' => 'ne', 'code3' => 'nep', 'flag' => 'E0c' ),
		764 => array( 'language_id' => 764, 'title' => 'Norwegian', 'code2' => 'no', 'code3' => 'nor', 'flag' => '4KE' ),
		765 => array( 'language_id' => 765, 'title' => 'Papiamento', 'code2' => 'pap', 'code3' => 'pap', 'flag' => 'none' ),
		766 => array( 'language_id' => 766, 'title' => 'Persian', 'code2' => 'fa', 'code3' => 'per', 'flag' => 'Vo7' ),
		767 => array( 'language_id' => 767, 'title' => 'Polish', 'code2' => 'pl', 'code3' => 'pol', 'flag' => 'j0R' ),
		768 => array( 'language_id' => 768, 'title' => 'Portuguese', 'code2' => 'pt', 'code3' => 'por', 'flag' => '1oU' ),
		769 => array( 'language_id' => 769, 'title' => 'Punjabi', 'code2' => 'pa', 'code3' => 'pan', 'flag' => 'n4T' ),
		770 => array( 'language_id' => 770, 'title' => 'Romanian', 'code2' => 'ro', 'code3' => 'rum', 'flag' => 'V5u' ),
		771 => array( 'language_id' => 771, 'title' => 'Russian', 'code2' => 'ru', 'code3' => 'rus', 'flag' => 'D1H' ),
		772 => array( 'language_id' => 772, 'title' => 'Scottish', 'code2' => 'gd', 'code3' => 'gla', 'flag' => '9MI' ),
		773 => array( 'language_id' => 773, 'title' => 'Serbian', 'code2' => 'sr', 'code3' => 'srp', 'flag' => 'GC6' ),
		774 => array( 'language_id' => 774, 'title' => 'Sinhala', 'code2' => 'si', 'code3' => 'sin', 'flag' => '9JL' ),
		775 => array( 'language_id' => 775, 'title' => 'Slovakian', 'code2' => 'sk', 'code3' => 'slk', 'flag' => 'Y2i' ),
		776 => array( 'language_id' => 776, 'title' => 'Slovenian', 'code2' => 'sl', 'code3' => 'slv', 'flag' => 'ZR1' ),
		777 => array( 'language_id' => 777, 'title' => 'Spanish', 'code2' => 'es', 'code3' => 'spa', 'flag' => 'A5d' ),
		778 => array( 'language_id' => 778, 'title' => 'Sundanese', 'code2' => 'su', 'code3' => 'sun', 'flag' => 'Wh1' ),
		779 => array( 'language_id' => 779, 'title' => 'Swahili', 'code2' => 'sw', 'code3' => 'swa', 'flag' => 'X3y' ),
		780 => array( 'language_id' => 780, 'title' => 'Swedish', 'code2' => 'sv', 'code3' => 'swe', 'flag' => 'oZ3' ),
		781 => array( 'language_id' => 781, 'title' => 'Tagalog', 'code2' => 'tl', 'code3' => 'tgl', 'flag' => '2qL' ),
		782 => array( 'language_id' => 782, 'title' => 'Tajik', 'code2' => 'tg', 'code3' => 'tgk', 'flag' => '7Qa' ),
		783 => array( 'language_id' => 783, 'title' => 'Tamil', 'code2' => 'ta', 'code3' => 'tam', 'flag' => 'My6' ),
		784 => array( 'language_id' => 784, 'title' => 'Tatar', 'code2' => 'tt', 'code3' => 'tat', 'flag' => 'D1H' ),
		785 => array( 'language_id' => 785, 'title' => 'Telugu', 'code2' => 'te', 'code3' => 'tel', 'flag' => 'My6' ),
		786 => array( 'language_id' => 786, 'title' => 'Thai', 'code2' => 'th', 'code3' => 'tha', 'flag' => 'V6r' ),
		787 => array( 'language_id' => 787, 'title' => 'Turkish', 'code2' => 'tr', 'code3' => 'tur', 'flag' => 'YZ9' ),
		788 => array( 'language_id' => 788, 'title' => 'Udmurt', 'code2' => 'udm', 'code3' => 'udm', 'flag' => 'none' ),
		789 => array( 'language_id' => 789, 'title' => 'Ukrainian', 'code2' => 'uk', 'code3' => 'ukr', 'flag' => '2Mg' ),
		790 => array( 'language_id' => 790, 'title' => 'Urdu', 'code2' => 'ur', 'code3' => 'urd', 'flag' => 'n4T' ),
		791 => array( 'language_id' => 791, 'title' => 'Uzbek', 'code2' => 'uz', 'code3' => 'uzb', 'flag' => 'zJ3' ),
		792 => array( 'language_id' => 792, 'title' => 'Vietnamese', 'code2' => 'vi', 'code3' => 'vie', 'flag' => 'l2A' ),
		793 => array( 'language_id' => 793, 'title' => 'Welsh', 'code2' => 'cy', 'code3' => 'wel', 'flag' => 'D4b' ),
		794 => array( 'language_id' => 794, 'title' => 'Xhosa', 'code2' => 'xh', 'code3' => 'xho', 'flag' => '7xS' ),
		795 => array( 'language_id' => 795, 'title' => 'Yiddish', 'code2' => 'yi', 'code3' => 'yid', 'flag' => '5KS' ),
	);

	var $flags = array(
		312 => array( 'flag_id' => 312, 'title' => 'Afghanistan', 'code' => 'NV2'),
		313 => array( 'flag_id' => 313, 'title' => 'Albania', 'code' => '5iM'),
		314 => array( 'flag_id' => 314, 'title' => 'Algeria', 'code' => '5W5'),
		315 => array( 'flag_id' => 315, 'title' => 'Andorra', 'code' => '0Iu'),
		316 => array( 'flag_id' => 316, 'title' => 'Angola', 'code' => 'R3d'),
		317 => array( 'flag_id' => 317, 'title' => 'Antigua and Barbuda', 'code' => '16M'),
		318 => array( 'flag_id' => 318, 'title' => 'Argentina', 'code' => 'V1f'),
		319 => array( 'flag_id' => 319, 'title' => 'Armenia', 'code' => 'q9U'),
		320 => array( 'flag_id' => 320, 'title' => 'Australia', 'code' => '2Os'),
		321 => array( 'flag_id' => 321, 'title' => 'Austria', 'code' => '8Dv'),
		322 => array( 'flag_id' => 322, 'title' => 'Azerbaijan', 'code' => 'Wg1'),
		323 => array( 'flag_id' => 323, 'title' => 'Bahamas', 'code' => '0qL'),
		324 => array( 'flag_id' => 324, 'title' => 'Bahrain', 'code' => 'D9A'),
		325 => array( 'flag_id' => 325, 'title' => 'Bangladesh', 'code' => '63A'),
		326 => array( 'flag_id' => 326, 'title' => 'Barbados', 'code' => 'u7L'),
		327 => array( 'flag_id' => 327, 'title' => 'Belarus', 'code' => 'O8S'),
		328 => array( 'flag_id' => 328, 'title' => 'Belgium', 'code' => '0AT'),
		329 => array( 'flag_id' => 329, 'title' => 'Belize', 'code' => 'lH4'),
		330 => array( 'flag_id' => 330, 'title' => 'Benin', 'code' => 'I2x'),
		331 => array( 'flag_id' => 331, 'title' => 'Bhutan', 'code' => 'D9z'),
		332 => array( 'flag_id' => 332, 'title' => 'Bolgariya', 'code' => 'V3p'),
		333 => array( 'flag_id' => 333, 'title' => 'Bolivia', 'code' => '8Vs'),
		334 => array( 'flag_id' => 334, 'title' => 'Bosnia and Herzegovina', 'code' => 'Z1t'),
		335 => array( 'flag_id' => 335, 'title' => 'Botswana', 'code' => 'Vf3'),
		336 => array( 'flag_id' => 336, 'title' => 'Brazil', 'code' => '1oU'),
		337 => array( 'flag_id' => 337, 'title' => 'Brunei', 'code' => '3rE'),
		338 => array( 'flag_id' => 338, 'title' => 'Burkina Faso', 'code' => 'x8P'),
		339 => array( 'flag_id' => 339, 'title' => 'Burundi', 'code' => '5qZ'),
		340 => array( 'flag_id' => 340, 'title' => 'Cambodia', 'code' => 'o8B'),
		341 => array( 'flag_id' => 341, 'title' => 'Cameroon', 'code' => '3cO'),
		342 => array( 'flag_id' => 342, 'title' => 'Canada', 'code' => 'P4g'),
		343 => array( 'flag_id' => 343, 'title' => 'Cape Verde', 'code' => 'R5O'),
		344 => array( 'flag_id' => 344, 'title' => 'Central African Republic', 'code' => 'kN9'),
		345 => array( 'flag_id' => 345, 'title' => 'Chad', 'code' => 'V5u'),
		346 => array( 'flag_id' => 346, 'title' => 'Chile', 'code' => 'wY3'),
		347 => array( 'flag_id' => 347, 'title' => 'China', 'code' => 'Z1v'),
		348 => array( 'flag_id' => 348, 'title' => 'Colombia', 'code' => 'a4S'),
		349 => array( 'flag_id' => 349, 'title' => 'Comoros', 'code' => 'N6k'),
		350 => array( 'flag_id' => 350, 'title' => 'Congo', 'code' => 'WK0'),
		351 => array( 'flag_id' => 351, 'title' => 'Costa Rica', 'code' => 'PP7'),
		352 => array( 'flag_id' => 352, 'title' => 'Cote d\'Ivoire', 'code' => '6PX'),
		353 => array( 'flag_id' => 353, 'title' => 'Croatia', 'code' => '7KQ'),
		354 => array( 'flag_id' => 354, 'title' => 'Cuba', 'code' => 'vU2'),
		355 => array( 'flag_id' => 355, 'title' => 'Cyprys', 'code' => 'Gw4'),
		356 => array( 'flag_id' => 356, 'title' => 'Czech Republic', 'code' => '1ZY'),
		357 => array( 'flag_id' => 357, 'title' => 'Democratic Republic of the Congo', 'code' => 'Kv5'),
		358 => array( 'flag_id' => 358, 'title' => 'Denmark', 'code' => 'Ro2'),
		359 => array( 'flag_id' => 359, 'title' => 'Djibouti', 'code' => 'MS7'),
		360 => array( 'flag_id' => 360, 'title' => 'Dominica', 'code' => 'E7U'),
		361 => array( 'flag_id' => 361, 'title' => 'Dominican Republic', 'code' => 'Eu2'),
		362 => array( 'flag_id' => 362, 'title' => 'Ecuador', 'code' => 'D90'),
		363 => array( 'flag_id' => 363, 'title' => 'Egypt', 'code' => '7LL'),
		364 => array( 'flag_id' => 364, 'title' => 'El Salvador', 'code' => '0zL'),
		365 => array( 'flag_id' => 365, 'title' => 'Equatorial Guinea', 'code' => 'b8T'),
		366 => array( 'flag_id' => 366, 'title' => 'Eritrea', 'code' => '8Gl'),
		367 => array( 'flag_id' => 367, 'title' => 'Estonia', 'code' => 'VJ8'),
		368 => array( 'flag_id' => 368, 'title' => 'Ethiopia', 'code' => 'ZH1'),
		369 => array( 'flag_id' => 369, 'title' => 'Fiji', 'code' => 'E1f'),
		370 => array( 'flag_id' => 370, 'title' => 'Finland', 'code' => 'nM4'),
		371 => array( 'flag_id' => 371, 'title' => 'France', 'code' => 'E77'),
		372 => array( 'flag_id' => 372, 'title' => 'Gabon', 'code' => 'R1u'),
		373 => array( 'flag_id' => 373, 'title' => 'Gambia', 'code' => 'TZ6'),
		374 => array( 'flag_id' => 374, 'title' => 'Georgia', 'code' => '8Ou'),
		375 => array( 'flag_id' => 375, 'title' => 'German', 'code' => 'K7e'),
		376 => array( 'flag_id' => 376, 'title' => 'Ghana', 'code' => '6Mr'),
		377 => array( 'flag_id' => 377, 'title' => 'Greece', 'code' => 'kY8'),
		378 => array( 'flag_id' => 378, 'title' => 'Grenada', 'code' => 'yG1'),
		379 => array( 'flag_id' => 379, 'title' => 'Guatemala', 'code' => 'aD8'),
		380 => array( 'flag_id' => 380, 'title' => 'Guinea', 'code' => '6Lm'),
		381 => array( 'flag_id' => 381, 'title' => 'Guinea-Bissau', 'code' => 'I39'),
		382 => array( 'flag_id' => 382, 'title' => 'Guyana', 'code' => 'Mh5'),
		383 => array( 'flag_id' => 383, 'title' => 'Haiti', 'code' => 'Qx7'),
		384 => array( 'flag_id' => 384, 'title' => 'Honduras', 'code' => 'm5Q'),
		385 => array( 'flag_id' => 385, 'title' => 'Hungary ', 'code' => 'OU2'),
		386 => array( 'flag_id' => 386, 'title' => 'Iceland', 'code' => 'Ho8'),
		387 => array( 'flag_id' => 387, 'title' => 'India', 'code' => 'My6'),
		388 => array( 'flag_id' => 388, 'title' => 'Indonesia', 'code' => 'G0m'),
		389 => array( 'flag_id' => 389, 'title' => 'Iran', 'code' => 'Vo7'),
		390 => array( 'flag_id' => 390, 'title' => 'Iraq', 'code' => 'z7I'),
		391 => array( 'flag_id' => 391, 'title' => 'Ireland', 'code' => '5Tr'),
		392 => array( 'flag_id' => 392, 'title' => 'Israel', 'code' => '5KS'),
		393 => array( 'flag_id' => 393, 'title' => 'Italy', 'code' => 'BW7'),
		394 => array( 'flag_id' => 394, 'title' => 'Jamaica', 'code' => 'u6W'),
		395 => array( 'flag_id' => 395, 'title' => 'Japan', 'code' => '4YX'),
		396 => array( 'flag_id' => 396, 'title' => 'Jordan', 'code' => 's2B'),
		397 => array( 'flag_id' => 397, 'title' => 'Kazakhstan', 'code' => 'QA5'),
		398 => array( 'flag_id' => 398, 'title' => 'Kenya', 'code' => 'X3y'),
		399 => array( 'flag_id' => 399, 'title' => 'Kiribati', 'code' => 'l2H'),
		400 => array( 'flag_id' => 400, 'title' => 'Kosovs', 'code' => 'Pb3'),
		401 => array( 'flag_id' => 401, 'title' => 'Kuwait', 'code' => 'P5F'),
		402 => array( 'flag_id' => 402, 'title' => 'Kyrgyzstan', 'code' => 'uP6'),
		403 => array( 'flag_id' => 403, 'title' => 'Laos', 'code' => 'Qy5'),
		404 => array( 'flag_id' => 404, 'title' => 'Latvia', 'code' => 'j1D'),
		405 => array( 'flag_id' => 405, 'title' => 'Lebanon', 'code' => 'Rl2'),
		406 => array( 'flag_id' => 406, 'title' => 'Lesotho', 'code' => 'lB1'),
		407 => array( 'flag_id' => 407, 'title' => 'Liberia', 'code' => '9Qw'),
		408 => array( 'flag_id' => 408, 'title' => 'Libya', 'code' => 'v6I'),
		409 => array( 'flag_id' => 409, 'title' => 'Liechtenstein', 'code' => '2GH'),
		410 => array( 'flag_id' => 410, 'title' => 'Lithuania', 'code' => 'uI6'),
		411 => array( 'flag_id' => 411, 'title' => 'Luxembourg', 'code' => 'EV8'),
		412 => array( 'flag_id' => 412, 'title' => 'Macedonia', 'code' => '6GV'),
		413 => array( 'flag_id' => 413, 'title' => 'Madagascar', 'code' => '4tE'),
		414 => array( 'flag_id' => 414, 'title' => 'Malawi', 'code' => 'O9C'),
		415 => array( 'flag_id' => 415, 'title' => 'Malaysia', 'code' => 'C9k'),
		416 => array( 'flag_id' => 416, 'title' => 'Maldives', 'code' => '1Q3'),
		417 => array( 'flag_id' => 417, 'title' => 'Mali', 'code' => 'Yi5'),
		418 => array( 'flag_id' => 418, 'title' => 'Malta', 'code' => 'N11'),
		419 => array( 'flag_id' => 419, 'title' => 'Marshall Islands', 'code' => 'Z3x'),
		420 => array( 'flag_id' => 420, 'title' => 'Mauritania', 'code' => 'F18'),
		421 => array( 'flag_id' => 421, 'title' => 'Mauritius', 'code' => 'mH4'),
		422 => array( 'flag_id' => 422, 'title' => 'Mexico', 'code' => '8Qb'),
		423 => array( 'flag_id' => 423, 'title' => 'Micronesia', 'code' => 'H6t'),
		424 => array( 'flag_id' => 424, 'title' => 'Moldova', 'code' => 'FD8'),
		425 => array( 'flag_id' => 425, 'title' => 'Monaco', 'code' => 't0X'),
		426 => array( 'flag_id' => 426, 'title' => 'Mongolia', 'code' => 'X8h'),
		427 => array( 'flag_id' => 427, 'title' => 'Montenegro', 'code' => '61A'),
		428 => array( 'flag_id' => 428, 'title' => 'Morocco', 'code' => 'M2e'),
		429 => array( 'flag_id' => 429, 'title' => 'Mozambique', 'code' => 'J7N'),
		430 => array( 'flag_id' => 430, 'title' => 'Myanmar ', 'code' => 'YB9'),
		431 => array( 'flag_id' => 431, 'title' => 'Namibia', 'code' => 'r0H'),
		432 => array( 'flag_id' => 432, 'title' => 'Nauru', 'code' => 'M09'),
		433 => array( 'flag_id' => 433, 'title' => 'Nepal', 'code' => 'E0c'),
		434 => array( 'flag_id' => 434, 'title' => 'Netherlands', 'code' => '8jV'),
		435 => array( 'flag_id' => 435, 'title' => 'New Zealand', 'code' => '0Mi'),
		436 => array( 'flag_id' => 436, 'title' => 'Nicaragua', 'code' => '5dN'),
		437 => array( 'flag_id' => 437, 'title' => 'Niger', 'code' => 'Rj0'),
		438 => array( 'flag_id' => 438, 'title' => 'Nigeria', 'code' => '8oM'),
		439 => array( 'flag_id' => 439, 'title' => 'North Korea', 'code' => '3Yz'),
		440 => array( 'flag_id' => 440, 'title' => 'Norvay', 'code' => '4KE'),
		441 => array( 'flag_id' => 441, 'title' => 'Oman', 'code' => '8NL'),
		442 => array( 'flag_id' => 442, 'title' => 'Pakistan', 'code' => 'n4T'),
		443 => array( 'flag_id' => 443, 'title' => 'Palau', 'code' => '8G2'),
		444 => array( 'flag_id' => 444, 'title' => 'Panama', 'code' => '93O'),
		445 => array( 'flag_id' => 445, 'title' => 'Papua New Guinea', 'code' => 'FD4'),
		446 => array( 'flag_id' => 446, 'title' => 'Paraguay', 'code' => 'y5O'),
		447 => array( 'flag_id' => 447, 'title' => 'Peru', 'code' => '4MJ'),
		448 => array( 'flag_id' => 448, 'title' => 'Philippines', 'code' => '2qL'),
		449 => array( 'flag_id' => 449, 'title' => 'Poland ', 'code' => 'j0R'),
		450 => array( 'flag_id' => 450, 'title' => 'Portugal', 'code' => '0Rq'),
		451 => array( 'flag_id' => 451, 'title' => 'Qatar', 'code' => 'a8S'),
		452 => array( 'flag_id' => 452, 'title' => 'Romania', 'code' => 'nC7'),
		453 => array( 'flag_id' => 453, 'title' => 'Russia', 'code' => 'D1H'),
		454 => array( 'flag_id' => 454, 'title' => 'Rwanda', 'code' => '8UD'),
		455 => array( 'flag_id' => 455, 'title' => 'Saint Kitts and Nevis', 'code' => 'X2d'),
		456 => array( 'flag_id' => 456, 'title' => 'Saint Lucia', 'code' => 'I5e'),
		457 => array( 'flag_id' => 457, 'title' => 'Saint Vincent and the Grenadines', 'code' => '3Kf'),
		458 => array( 'flag_id' => 458, 'title' => 'Samoa', 'code' => '54E'),
		459 => array( 'flag_id' => 459, 'title' => 'San Marino', 'code' => 'K4F'),
		460 => array( 'flag_id' => 460, 'title' => 'Sao Tome and Principe', 'code' => 'cZ9'),
		461 => array( 'flag_id' => 461, 'title' => 'Saudi Arabia', 'code' => 'J06'),
		462 => array( 'flag_id' => 462, 'title' => 'Senegal', 'code' => 'x2O'),
		463 => array( 'flag_id' => 463, 'title' => 'Serbia', 'code' => 'GC6'),
		464 => array( 'flag_id' => 464, 'title' => 'Seychelles', 'code' => 'JE6'),
		465 => array( 'flag_id' => 465, 'title' => 'Sierra Leone', 'code' => 'mS4'),
		466 => array( 'flag_id' => 466, 'title' => 'Singapore', 'code' => 'O6e'),
		467 => array( 'flag_id' => 467, 'title' => 'Slovakia', 'code' => 'Y2i'),
		468 => array( 'flag_id' => 468, 'title' => 'Slovenia', 'code' => 'ZR1'),
		469 => array( 'flag_id' => 469, 'title' => 'Solomon Islands', 'code' => '0U1'),
		470 => array( 'flag_id' => 470, 'title' => 'Somalia', 'code' => '3fH'),
		471 => array( 'flag_id' => 471, 'title' => 'South Africa', 'code' => '7xS'),
		472 => array( 'flag_id' => 472, 'title' => 'South Korea', 'code' => '0W3'),
		473 => array( 'flag_id' => 473, 'title' => 'South Sudan', 'code' => 'H4u'),
		474 => array( 'flag_id' => 474, 'title' => 'Spain', 'code' => 'A5d'),
		475 => array( 'flag_id' => 475, 'title' => 'Sri Lanka', 'code' => '9JL'),
		476 => array( 'flag_id' => 476, 'title' => 'Sudan', 'code' => 'Wh1'),
		477 => array( 'flag_id' => 477, 'title' => 'Suriname', 'code' => '7Rb'),
		478 => array( 'flag_id' => 478, 'title' => 'Swaziland', 'code' => 'f6L'),
		479 => array( 'flag_id' => 479, 'title' => 'Sweden', 'code' => 'oZ3'),
		480 => array( 'flag_id' => 480, 'title' => 'Switzerland', 'code' => '8aW'),
		481 => array( 'flag_id' => 481, 'title' => 'Syria', 'code' => 'UZ9'),
		482 => array( 'flag_id' => 482, 'title' => 'Taiwan', 'code' => 'Rg9'),
		483 => array( 'flag_id' => 483, 'title' => 'Tajikistan', 'code' => '7Qa'),
		484 => array( 'flag_id' => 484, 'title' => 'Tanzania', 'code' => 'VU7'),
		485 => array( 'flag_id' => 485, 'title' => 'Thailand', 'code' => 'V6r'),
		486 => array( 'flag_id' => 486, 'title' => 'Timor-Leste', 'code' => '52C'),
		487 => array( 'flag_id' => 487, 'title' => 'Togo', 'code' => 'HH3'),
		488 => array( 'flag_id' => 488, 'title' => 'Tonga', 'code' => '8Ox'),
		489 => array( 'flag_id' => 489, 'title' => 'Trinidad and Tobago', 'code' => 'oZ8'),
		490 => array( 'flag_id' => 490, 'title' => 'Tunisia', 'code' => 'pD6'),
		491 => array( 'flag_id' => 491, 'title' => 'Turkey', 'code' => 'YZ9'),
		492 => array( 'flag_id' => 492, 'title' => 'Turkmenistan', 'code' => 'Tm5'),
		493 => array( 'flag_id' => 493, 'title' => 'Tuvalu', 'code' => 'u0Y'),
		494 => array( 'flag_id' => 494, 'title' => 'Uganda', 'code' => 'eJ2'),
		495 => array( 'flag_id' => 495, 'title' => 'Ukraine', 'code' => '2Mg'),
		496 => array( 'flag_id' => 496, 'title' => 'United Arab Emirates', 'code' => 'DT3'),
		497 => array( 'flag_id' => 497, 'title' => 'United Kingdom', 'code' => 'Dw0'),
		498 => array( 'flag_id' => 498, 'title' => 'United States of America', 'code' => 'R04'),
		499 => array( 'flag_id' => 499, 'title' => 'Uruguay', 'code' => 'aL9'),
		500 => array( 'flag_id' => 500, 'title' => 'Uzbekistan', 'code' => 'zJ3'),
		501 => array( 'flag_id' => 501, 'title' => 'Vanuatu', 'code' => 'D0Y'),
		502 => array( 'flag_id' => 502, 'title' => 'Vatican City', 'code' => 'FG2'),
		503 => array( 'flag_id' => 503, 'title' => 'Venezuela', 'code' => 'Eg6'),
		504 => array( 'flag_id' => 504, 'title' => 'Vietnam', 'code' => 'l2A'),
		505 => array( 'flag_id' => 505, 'title' => 'Yemen', 'code' => 'YZ0'),
		506 => array( 'flag_id' => 506, 'title' => 'Zambia', 'code' => '9Be'),
		507 => array( 'flag_id' => 507, 'title' => 'Zimbabwe', 'code' => '80Y'),
	);

	function __construct()
	{
		load_plugin_textdomain( 'conveythis-translate' );

		$this->api_key = get_option( 'api_key' );
		$this->source_language = get_option( 'source_language' );
		$this->target_languages = get_option( 'target_languages', array() );
		$this->style_change_language = get_option( 'style_change_language', array() );
		$this->style_change_flag = get_option( 'style_change_flag', array() );
		$this->style_flag = get_option( 'style_flag', 'rect' );
		$this->style_text = get_option( 'style_text', 'full-text' );
		$this->style_position_vertical = get_option( 'style_position_vertical', 'top' );
		$this->style_position_horizontal = get_option( 'style_position_horizontal', 'right' );
		$this->style_indenting_vertical = get_option( 'style_indenting_vertical', '0' );
		$this->style_indenting_horizontal = get_option( 'style_indenting_horizontal', '24' );
		$this->auto_translate = get_option( 'auto_translate', '1' );
		$this->hide_conveythis_logo = get_option( 'hide_conveythis_logo', '0' );
		$this->alternate = get_option( 'alternate', '1' );
		$this->accept_language = get_option( 'accept_language', '0' );
		$this->blockpages = get_option( 'blockpages', array() );
		$this->show_javascript = get_option( 'show_javascript', '1' );
		//

		$this->blockpages_items = array();

		foreach( $this->blockpages as $blockpage )
		{
			if( !empty( $blockpage ) )
			{
				$page_url = $this->getPageUrl( $blockpage );
				$this->blockpages_items[] = $page_url;
			}
		}

		//

		$plugin = plugin_basename( __FILE__ );

		add_filter( 'plugin_action_links_' . $plugin, array( $this, '_settings_link' ) );
		add_filter( 'plugin_row_meta', array( $this, '_row_meta' ), 10, 2 );
		add_filter( 'wp_nav_menu', array( $this, '_menu_shortcode' ), 20, 2 );

		add_action( 'init', array( $this, '_init' ) );
		
		add_action( 'admin_menu', array( $this, '_admin_menu' ) );
        add_action( 'admin_init', array( $this, '_admin_init' ) );
		add_action( 'admin_notices', array( $this, '_admin_notices' ), 10 ) ;

		add_action( 'admin_head-nav-menus.php', array( $this, 'add_nav_menu_meta_boxes' ) );
		add_filter( 'nav_menu_link_attributes', array( $this, 'magellanlinkfilter' ), 10, 3 );


		}

	public function magellanlinkfilter( $attr, $post, $menu )
	{
		preg_match( '/\[ConveyThis_(.*)\]/', $post->title, $matches );

		if( !empty( $matches ) )
		{
			$language = $this->searchLanguage( $matches[1] );

			if( !empty( $language ) )
			{
				if( !empty( $this->language_code ) )
				{
					if( $language['code2'] === $this->source_language )
					{
						$language = $this->searchLanguage( $this->language_code );
					}

					else if( $language['code2'] === $this->language_code )
					{
						$language = $this->searchLanguage( $this->source_language );
					}
				}

				//

				$site_url = site_url();
				$prefix = $this->getPageUrl( $site_url );

				$location = $this->getLocation( $prefix, $language['code2'] );
				$icon = $this->genIcon( $language['language_id'], $language['flag'] );
				$attr['translate'] = 'no';
				$attr['href'] = $location;

				if( $this->style_text === 'full-text' )
				{
					$post->title = $icon . $language['title'];						
				}
				if( $this->style_text === 'short-text' )
				{
					$post->title = $icon . strtoupper( $language['code3'] );
				}
				if( $this->style_text === 'without-text' )
				{
					$post->title = $icon;
				}
			}
		}

		return $attr;
	}

	public function genIcon( $language_id, $flag )
	{
		$i = 0;

		while( $i < 5 )
		{
			if( !empty( $this->style_change_language[$i] ) && $this->style_change_language[$i] == $language_id )
			{
				$flag = $this->style_change_flag[$i];
			}
			$i++;
		}

		//

		$icon = '';

		if( $this->style_flag === 'rect' )
		{
			$icon = '<span style="height: 20px; width: 30px; background-image: url(\'//cdn.conveythis.com/images/flags/v2/rectangular/' . $flag . '.png\'); display: inline-block; background-position: 50% 50%; background-repeat: no-repeat; background-color: transparent; margin-right: 10px; vertical-align: middle;"></span>';
		}

		if( $this->style_flag === 'sqr' )
		{
			$icon = '<span style="height: 24px; width: 24px; background-image: url(\'//cdn.conveythis.com/images/flags/v2/square/' . $flag . '.png\'); display: inline-block; background-position: 50% 50%; background-repeat: no-repeat; background-color: transparent; margin-right: 10px; vertical-align: middle;"></span>';
		}

		if( $this->style_flag === 'cir' )
		{
			$icon = '<span style="height: 24px; width: 24px; background-image: url(\'//cdn.conveythis.com/images/flags/v2/round/' . $flag . '.png\'); display: inline-block; background-position: 50% 50%; background-repeat: no-repeat; background-color: transparent; margin-right: 10px; vertical-align: middle;"></span>';
		}

		if( $this->style_flag === 'without-flag' )
		{
			$icon = '';
		}

		return $icon;
	}

	public function _menu_shortcode( $menu, $args )
	{
		return do_shortcode( $menu );
	}

	public function add_nav_menu_meta_boxes()
	{
		add_meta_box( 'conveythis_nav_link', __( 'ConveyThis', 'conveythis-translate' ), array( $this, 'nav_menu_links' ), 'nav-menus', 'side', 'low' );
	}

	public function nav_menu_links()
	{
		$languages = array();

		if( !empty( $this->language_code ) )
		{
			$current_language_code = $this->language_code;
		}

		else
		{
			$current_language_code = $this->source_language;
		}

		//

		$language = $this->searchLanguage( $current_language_code );

		if( !empty( $language ) )
		{
			$languages[] = array(
				'id' => $language['language_id'],
				'title' => $language['title'],
			);
		}

		if( !empty( $this->language_code ) )
		{
			$language = $this->searchLanguage( $this->source_language );

			if( !empty( $language ) )
			{
				$languages[] = array(
					'id' => $language['language_id'],
					'title' => $language['title'],
				);
			}
		}

		foreach( $this->target_languages as $language_code )
		{
			$language = $this->searchLanguage( $language_code );

			if( !empty( $language ) )
			{
				if( $current_language_code != $language['code2'] )
				{
					$languages[] = array(
						'id' => $language['language_id'],
						'title' => $language['title'],
					);
				}
			}
		}
		?>
		<div id="posttype-conveythis-languages" class="posttypediv">
			<div id="tabs-panel-conveythis-endpoints" class="tabs-panel tabs-panel-active">
				<ul id="conveythis-endpoints-checklist" class="categorychecklist form-no-clear">

					<?php foreach( $languages as $index => $language ) : ?>

						<li>
							<label class="menu-item-title">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo esc_attr( $index + 1 ); ?>][menu-item-object-id]" value="<?php echo esc_attr( $index + 1 ); ?>" /> <?php echo esc_html( $language['title'] ); ?>
							</label>
							<input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr( $index + 1 ); ?>][menu-item-type]" value="custom" />
							<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr( $index + 1 ); ?>][menu-item-title]" value="[ConveyThis_<?php echo esc_html( $language['title'] ); ?>]" />

							<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr( $index + 1 ); ?>][menu-item-classes]" />
						</li>

					<?php endforeach; ?>

				</ul>
			</div>
			<p class="button-controls">
				<span class="list-controls">
					<a href="<?php echo esc_url( admin_url( 'nav-menus.php?page-tab=all&selectall=1#posttype-conveythis-languages' ) ); ?>" class="select-all"><?php esc_html_e( 'Select all', 'conveythis-translate' ); ?></a>
				</span>
				<span class="add-to-menu">
					<button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to menu', 'conveythis-translate' ); ?>" name="add-post-type-menu-item" id="submit-posttype-conveythis-languages"><?php esc_html_e( 'Add to menu', 'conveythis-translate' ); ?></button>
					<span class="spinner"></span>
				</span>
			</p>
		</div>
		<?php
	}

	function _row_meta( $links, $file )
	{
		$plugin = plugin_basename( __FILE__ );

		if( $plugin == $file )
		{
			$links[] = '<a href="https://www.conveythis.com/help-center/support-and-resources/?utm_source=widget&utm_medium=wordpress" target="_blank">' . __( 'FAQ', 'conveythis-translate' ) . '</a>';
			$links[] = '<a href="https://wordpress.org/support/plugin/conveythis-translate" target="_blank">' . __( 'Support', 'conveythis-translate' ) . '</a>';
			$links[] = '<a href="https://wordpress.org/plugins/conveythis-translate/#reviews" target="_blank">' . __( 'Rate this plugin', 'conveythis-translate' ) . '</a>';

		}
		return $links;
	}

	function _settings_link( $links )
	{
		array_push( $links, '<a href="options-general.php?page=convey_this">' . __( 'Settings', 'conveythis-translate' ) . '</a>' );

		return $links;
	}

	function _admin_menu()
	{
add_menu_page('ConveyThis Settings', 'ConveyThis', 'manage_options', 'convey_this', array( $this, 'pluginOptions' ), 'dashicons-translation' );
	}

	function _admin_notices()
	{
		if( empty( $this->api_key ) )
		{
			?>
			<div class="error settings-error notice is-dismissible">
				<p>
					<?php echo __( 'ConveyThis plugin installed but not yet configured.', 'conveythis-translate' ); ?>
					<?php if( $_REQUEST['page'] != 'convey_this' ): ?>

						<?php echo __( 'You need to configure ConveyThis plugin here:', 'conveythis-translate' ); ?>
						<a href="<?php echo admin_url('options-general.php') . '?page=convey_this'; ?>"><?php echo __( 'configuration page', 'conveythis-translate' ); ?></a>

					<?php endif; ?>
				</p>
			</div>
			<?php
		}

		if( !extension_loaded('xml') )
		{
			?>
			<div class="error settings-error notice is-dismissible">
				<p>
					<?php echo __( 'Plugin requires installing php-xml extension.', 'conveythis-translate' ); ?>
				</p>
			</div>
			<?php
		}
	}

	function _admin_init()
	{
		register_setting( 'my-plugin-settings-group', 'api_key' );
		register_setting( 'my-plugin-settings-group', 'source_language' );
		register_setting( 'my-plugin-settings-group', 'target_languages', array( $this, '_check_target_languages' ) );

		register_setting( 'my-plugin-settings-group', 'style_change_language', array( $this, '_check_style_change_language' ) );
		register_setting( 'my-plugin-settings-group', 'style_change_flag', array( $this, '_check_style_change_flag' ) );
		register_setting( 'my-plugin-settings-group', 'style_flag' );
		register_setting( 'my-plugin-settings-group', 'style_text' );
		register_setting( 'my-plugin-settings-group', 'style_position_vertical' );
		register_setting( 'my-plugin-settings-group', 'style_position_horizontal' );
		register_setting( 'my-plugin-settings-group', 'style_indenting_vertical' );
		register_setting( 'my-plugin-settings-group', 'style_indenting_horizontal' );
		register_setting( 'my-plugin-settings-group', 'auto_translate' );
		register_setting( 'my-plugin-settings-group', 'hide_conveythis_logo' );

		register_setting( 'my-plugin-settings-group', 'alternate' );
		register_setting( 'my-plugin-settings-group', 'accept_language' );
		register_setting( 'my-plugin-settings-group', 'blockpages', array( $this, '_check_blockpages' ) );
		register_setting( 'my-plugin-settings-group', 'show_javascript' );

		if( !empty( $_REQUEST['page'] ) && $_REQUEST['page'] == 'convey_this' )
		{
			if( empty( $_POST ) )
			{
				if( !empty( $this->api_key ) )
				{
					$this->send( 'PUT', '/website/update/', array(
						'referrer' => '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
						'source_language' => $this->source_language,
						'target_languages' => $this->target_languages,
						'accept_language' => $this->accept_language,	// Option
						'blockpages' => $this->blockpages_items,
					));
				}
			}
		}
    }

	function _check_style_change_language( $value )
	{
		if( !is_array( $value ) )
		{
			return array();
		}

		return $value;
	}

	function _check_style_change_flag( $value )
	{
		if( !is_array( $value ) )
		{
			return array();
		}

		return $value;
	}

	function _check_blockpages( $value )
	{
		if( !empty( $value ) )
		{
			return explode( "\n", $value );
		}

		else
		{
			return array();
		}
	}

	function _check_target_languages( $value )
	{
		if( !empty( $value ) )
		{
		    $target_languages = array();
			$language_codes = explode( ',', $value );

            foreach( $language_codes as $language_code )
            {
				$language = $this->searchLanguage( $language_code );

				if( !empty( $language ) )
				{
					$target_languages[] = $language['code2'];					
				}
            }
            return $target_languages;
		}

		else
		{
			return array();
		}
	}

	public function searchLanguage( $value )
	{
		foreach( $this->languages as $language )
		{
			if( $value === $language['code2'] || $value === $language['title'] )
			{
				return $language;
			}
		}
	}

	function getPageUrl( $str )
	{
		$n = 0;
		$length = strlen( $str );
		$buffer = '';
		$step = 0;

		while( $n < $length )
		{
			if( $str[$n] === '/' )
			{
				if( $step === 1 ) $step = 2;

				if( $step === 0 )
				{
					$buffer = '/';
					$step = 1;
				}
			}

			else
			{
				if( $step === 2 )
				{
					$buffer = '';
					$step = 0;
				}

				if( $step === 1 ) $step = 3;
			}

			if( $str[$n] === '?' || $str[$n] === '#' ) break;
			if( $step === 3 ) $buffer .= $str[$n];

			$n++;
		}

		$buffer = trim( $buffer );
		$buffer = rtrim( $buffer, '/' );

		if( empty( $buffer ) )
		{
			$buffer = '/';
		}
		return rtrim( $buffer, '/' ) . '/';
	}

	function _init()
	{
		if( !is_admin() )
		{
			if($this->auto_translate){
				
				$browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

				if (in_array($browserLanguage, $this->target_languages)) {

					session_start();
					if (empty($_SESSION['conveythis-autoredirected'])){
						
						$_SESSION['conveythis-autoredirected'] = true;
						$site_url = site_url();
						$site_prefix = $this->getPageUrl( $site_url );
						
						$location = $this->getLocation($site_prefix, $browserLanguage);
						header("Location: ".$location);
						die();
					}
				}
			}
			
			$this->site_url = site_url();
			$this->site_prefix = $this->getPageUrl( $this->site_url );
			
			$site_url = site_url();
			$prefix = $this->getPageUrl( $site_url );
			
			$this->referrer = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			if( !empty( $this->target_languages ) )
			{
				preg_match( '/^('.str_replace( '/', '\/', $prefix ).'('. implode( '|', $this->target_languages ) .')\/).*/', $_SERVER["REQUEST_URI"], $matches );

				if( !empty( $matches ) )
				{
					$this->language_code = esc_attr( $matches[2] );

					$tmp = esc_attr( $matches[1] );

					$origin = $_SERVER["REQUEST_URI"];
					$_SERVER["REQUEST_URI"] = esc_url( substr_replace( $_SERVER["REQUEST_URI"], $prefix, 0, strlen( $tmp ) ) );
					$this->referrer = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$page_url = $this->getPageUrl( $this->referrer );
					
					if( in_array( $page_url, $this->blockpages_items ) )
					{
						$_SERVER["REQUEST_URI"] = $origin;
						$this->language_code = null;
					}
				}
			}

			//

			if( !empty( $this->source_language ) && !empty( $this->target_languages ) )
			{
				$page_url = $this->getPageUrl( $this->referrer );

				if( !in_array( $page_url, $this->blockpages_items ) )
				{
					if( !empty( $this->show_javascript ) )
					{
						add_action( 'wp_footer', array( $this, '_inline_script' ) );
					}
				}
			}

			if( !empty( $this->alternate ) )
			{
				add_action( 'wp_head', array( $this, '_alternate' ), 0 );

				if( !empty( $this->language_code ) )
				{
					add_filter( 'locale', function( $value ) {
						return $this->language_code;
					});
				}

				else
				{
					add_filter( 'locale', function( $value ) {
						$langs = explode( '_', $value );
						return $langs[0];
					});					
				}
			}

			//~ if( !empty( $this->accept_language ) && empty( $this->language_code ) )
			//~ {
				//~ if( !empty( $_SERVER['REQUEST_URI'] ) && !empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) )
				//~ {
					//~ $this->languageAccept( $_SERVER['REQUEST_URI'], $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
				//~ }
			//~ }

			ob_start();
			add_action( 'shutdown', array( $this, '_shutdown' ), 0 );
		}

		else
		{
			new conveythis_admin_notices();
		}
	}

	public function languageAccept( $data, $value )
	{
		$languages = explode( ',', $value );

		if( !empty( $languages ) )
		{
			foreach( $languages as $language )
			{
				$tmp = explode( ';', $language );
				$code = explode( '-', $tmp[0] );

				if( in_array( $code[0], $this->target_languages ) )
				{
					$location = $this->replaceLink( $data, $code[0] );

					header('Location: ' . $location );
					break;
				}
			}
		}
	}

	public function _alternate()
	{
		$prefix = $this->getPageUrl( $this->site_url );
		$location = $this->getLocation( $prefix, $this->source_language );

		echo '<link rel="alternate" href="' . $this->site_url . ''. $location .'" hreflang="x-default">';
		echo "\n";

		$data = array_merge( $this->target_languages, array( $this->source_language ) );

		foreach( $data as $value )
		{
			$language = $this->searchLanguage( $value );

			if( !empty( $language ) )
			{
				$location = $this->getLocation( $prefix, $language['code2'] );

				echo '<link rel="alternate" href="' . $this->site_url . ''. $location .'" hreflang="'. esc_attr( $language['code2'] ) .'">';
				echo "\n";				
			}
		}
	}

	public function getLocation( $prefix, $language_code )
	{
		if( $this->source_language == $language_code )
		{
			return $_SERVER["REQUEST_URI"];
		}

		else
		{
			return substr_replace( $_SERVER["REQUEST_URI"], $prefix . '' . $language_code . '/', 0, strlen( $prefix ) );			
		}
	}

	function pluginOptions()
	{
		if( !current_user_can( 'manage_options' ) )
		{
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		require_once( 'settings.php' );
 	}

	public function _inline_script()
	{
		$site_url = site_url();
		$prefix = $this->getPageUrl( $site_url );

		//

		$languages = array();

		if( !empty( $this->language_code ) )
		{
			$current_language_code = $this->language_code;
		}

		else
		{
			$current_language_code = $this->source_language;
		}

		//

		$language = $this->searchLanguage( $current_language_code );

		if( !empty( $language ) )
		{
			$location = $this->getLocation( $prefix, $language['code2'] );

			$languages[] = '{"id":"'. esc_attr( $language['language_id'] ) .'", "location":"'. esc_attr( $location ) .'", "active":true}';

		}

		//

		if( !empty( $this->language_code ) )
		{
			$language = $this->searchLanguage( $this->source_language );

			if( !empty( $language ) )
			{
				$location = $this->getLocation( $prefix, $language['code2'] );

				$languages[] = '{"id":"'. esc_attr( $language['language_id'] ) .'", "location":"'. esc_attr( $location ) .'", "active":false}';
			}
		}

		foreach( $this->target_languages as $language_code )
		{
			$language = $this->searchLanguage( $language_code );

			if( !empty( $language ) )
			{
				if( $current_language_code != $language['code2'] )
				{
					$location = $this->getLocation( $prefix, $language['code2'] );

					$languages[] = '{"id":"'. esc_attr( $language['language_id'] ) .'", "location":"'. esc_attr( $location ) .'", "active":false}';
				}
			}
		}

		//

		$source_language_id = 0;

		if( !empty( $this->source_language ) )
		{
			$language = $this->searchLanguage( $this->source_language );

			if( !empty( $language ) )
			{
				$source_language_id = $language['language_id'];
			}
		}

		//

		$i = 0;

		$temp = array();

		while( $i < 5 )
		{
			if( !empty( $this->style_change_language[$i] ) )
			{
				$temp[] = '"' . $this->style_change_language[$i] . '":"' . $this->style_change_flag[$i] . '"';
			}
			$i++;
		}

		$change = '{' . implode( ',', $temp ) .'}';

		//

		if( $this->style_position_vertical == 'top' ){
			$positionTop = $this->style_indenting_vertical;
			$positionBottom = "null";
		}else{
			$positionTop = "null";
			$positionBottom = $this->style_indenting_vertical;
		}
		
		if( $this->style_position_horizontal == 'left' ){
			$positionLeft = $this->style_indenting_horizontal;
			$positionRight = "null";
		}else{
			$positionLeft = "null";
			$positionRight = $this->style_indenting_horizontal;
		}

		//

		// if( extension_loaded('xml') )
		// //~ if( false )
		// {
			// echo '<script src="' . CONVEYTHIS_JAVASCRIPT_PLUGIN_URL . '/conveythis.js"></script>';
		// }

		// else
		// {
			// echo '<script src="' . CONVEYTHIS_JAVASCRIPT_PLUGIN_URL . '/conveythis.js"></script>';
			// echo '<script src="' . CONVEYTHIS_JAVASCRIPT_PLUGIN_URL . '/translate.js"></script>';
		// }
		echo '<script src="' . CONVEYTHIS_JAVASCRIPT_PLUGIN_URL . '/conveythis.js"></script>';
		echo '<script src="' . CONVEYTHIS_JAVASCRIPT_PLUGIN_URL . '/translate.js"></script>';
		echo "\n";
		echo '<script type="text/javascript">';
		echo 'document.addEventListener("DOMContentLoaded", function(e) {';
		echo 'conveythis.init({';
		echo 'change:' . $change . ',';
		echo 'icon:"' . esc_attr( $this->style_flag ) . '",';
		echo 'text:"' . esc_attr( $this->style_text ) . '",';
		echo 'positionTop:' . esc_attr( $positionTop ) . ',';
		echo 'positionBottom:' . esc_attr( $positionBottom ) . ',';
		echo 'positionLeft:' . esc_attr( $positionLeft ) . ',';
		echo 'positionRight:' . esc_attr( $positionRight ) . ',';
		echo 'languages:[' . implode( ', ', $languages ) . '],';
		echo 'api_key:"' . esc_attr( $this->api_key ) . '",';
		echo 'source_language_id:"' . esc_attr( $source_language_id ) . '",';
		echo 'auto_translate:' . esc_attr( $this->auto_translate ) . ',';
		echo 'hide_conveythis_logo:' . esc_attr( $this->hide_conveythis_logo ) . ',';
		echo 'php_plugin_cur_lang:"' . $this->searchLanguage( $current_language_code )['language_id'] . '"';
		echo '});';
		echo '});';
		echo '</script>';
		echo "\n";
	}

	// DOM

	function domRecursiveRead( $doc )
	{
		foreach( $doc->childNodes as $child )
		{
			if( $child->nodeType === 3 )
			{
				$value = trim( $child->textContent );

				if( !empty( $value ) )
				{
					$this->segments[$value] = $value;
				}
			}

			else
			{
				if( $child->nodeType === 1 )
				{
					if( $child->hasAttribute('title') )
					{
						$attrValue = trim( $child->getAttribute('title') );
					}

					if( $child->hasAttribute('alt') )
					{
						$attrValue = trim( $child->getAttribute('alt') );
					}

					if( $child->hasAttribute('placeholder') )
					{
						$attrValue = trim( $child->getAttribute('placeholder') );
					}

					if( $child->hasAttribute( 'type' ) )
					{
						$attrTypeValue = trim( $child->getAttribute( 'type' ) );

						if( strcasecmp( $attrTypeValue, 'submit' ) === 0 || strcasecmp( $attrTypeValue, 'reset' ) === 0)
						{
							if( $child->hasAttribute( 'value' ) )
							{
								$attrValue = trim( $child->getAttribute( 'value' ) );
							}
						}
					}

					if( !empty( $attrValue ) )
					{
						$this->segments[$attrValue] = $attrValue;							
					}

					if( strcasecmp( $child->nodeName, 'meta' ) === 0 )
					{
						if( $child->hasAttribute('name') )
						{
							$metaAttributeName = trim( $child->getAttribute('name') );

							if( strcasecmp( $metaAttributeName, 'description' ) === 0 || strcasecmp( $metaAttributeName, 'keywords' ) === 0 )
							{
								if( $child->hasAttribute('content') )
								{
									$metaAttrValue = trim( $child->getAttribute('content') );

									if( !empty( $metaAttrValue ) )
									{
										$this->segments[$metaAttrValue] = $metaAttrValue;							
									}
								}
							}							
						}
					}

					if( strcasecmp( $child->nodeName, 'script' ) !== 0 && strcasecmp( $child->nodeName, 'style' ) !== 0 )
					{
						$this->domRecursiveRead( $child );
					}
				}
			}
		}
	}

	function replaceSegments( $output )
	{
		
		$output = preg_replace_callback( '/>([^<>]+)</', function ( $matches ) {
			
			$segment = $this->searchSegment( $matches[1] );

			if( !empty( $segment ) )
			{
				return '>' . $segment . '<';
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		$output = preg_replace_callback('/(content|placeholder|alt|title)(\s+)?=(\s+)?"([^"]+)"/', function ( $matches ) {
			
			$segment = $this->searchSegment( $matches[4] );

			if( !empty( $segment ) )
			{
				return $matches[1] . '="' . $segment . '"';
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		$output = preg_replace_callback("/(content|placeholder|alt|title)(\s+)?=(\s+)?'([^']+)'/", function ( $matches ) {

			$segment = $this->searchSegment( $matches[4] );

			if( !empty( $segment ) )
			{
				return $matches[1] . "='" . $segment . "'";
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);


		$output = preg_replace_callback('/type="(submit|reset)"(\s+)?value=(\s+)?"([^"]+)"/', function ( $matches ) {

			$segment = $this->searchSegment( $matches[4] );

			if( !empty( $segment ) )
			{
				return 'type='.$matches[1].' value="'.esc_html($segment).'"';
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		
		$output = preg_replace_callback( '/(<(\s+)?a([^<]+)href(\s+)?=(\s+)?)"([^"]+)"(([^>]+)?>)/', function ( $matches ) {

			if( !preg_match( '/translate="no"/', $matches[0] ) )
			{
				$temp = $this->replaceLink( $matches[6], $this->language_code );

				if( !empty( $temp ) )
				{
					return $matches[1] . '"' . $temp . '"' . $matches[7];
				}
				
				else
				{
					return $matches[0];
				}
			}

			else
			{
				return $matches[0];
			}

		}, $output);

		$output = preg_replace_callback( "/(<(\s+)?a([^<]+)href(\s+)?=(\s+)?)'([^']+)'(([^>]+)?>)/", function ( $matches ) {

			if( !preg_match( '/translate="no"/', $matches[0] ) )
			{
				$temp = $this->replaceLink( $matches[6], $this->language_code );

				if( !empty( $temp ) )
				{
					return $matches[1] . "'" . $temp . "'" . $matches[7];
				}
				
				else
				{
					return $matches[0];
				}
			}

			else
			{
				return $matches[0];
			}

		}, $output);


		$output = preg_replace_callback( '/(<(\s+)?img([^<]+)src(\s+)?=(\s+)?)"([^"]+)"/', function ( $matches ) {

			$metaAttrValue = $matches[6];

			if( strpos( $metaAttrValue, '//' ) === false )
			{
				if( strncmp( $metaAttrValue, $this->site_url, strlen( $this->site_url ) ) !== 0 )
				{
					$newAttrValue = rtrim( $this->site_url, '/' ) . '/' . ltrim( $metaAttrValue, '/' );

					return $matches[1] . '"' . $newAttrValue . '"';
				}
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		$output = preg_replace_callback( '/(<(\s+)?link([^<]+)canonical([^<]+)href(\s+)?=(\s+)?)"([^"]+)"/', function ( $matches ) {

			$temp = $this->replaceLink( $matches[7], $this->language_code );

			if( !empty( $temp ) )
			{
				return $matches[1] . '"' . $temp . '"';
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		$output = preg_replace_callback( "/(<(\s+)?link([^<]+)canonical([^<]+)href(\s+)?=(\s+)?)'([^']+)'/", function ( $matches ) {

			$temp = $this->replaceLink( $matches[7], $this->language_code );

			if( !empty( $temp ) )
			{
				return $matches[1] . "'" . $temp . "'";
			}
			
			else
			{
				return $matches[0];
			}

		}, $output);

		return $output;
	}

	function domRecursiveApply( $doc, $items )
	{
		foreach( $doc->childNodes as $child )
		{
			if( $child->nodeType === 3 )
			{
				$value = $child->textContent;
				$segment = $this->searchSegment( $value, $items );

				if( !empty( $segment ) )
				{
					$child->textContent = $segment;						
				}
			}

			else
			{
				if( $child->nodeType === 1 )
				{
					if( $child->hasAttribute( 'title' ) )
					{
						$attrValue = $child->getAttribute( 'title' );
						$segment = $this->searchSegment( $attrValue, $items );

						if( !empty( $segment ) )
						{
							$child->setAttribute( 'title', $segment );
						}
					}

					if( $child->hasAttribute( 'alt' ) )
					{
						$attrValue = $child->getAttribute( 'alt' );
						$segment = $this->searchSegment( $attrValue, $items );

						if( !empty( $segment ) )
						{
							$child->setAttribute( 'alt', $segment );
						}
					}

					if( $child->hasAttribute( 'placeholder' ) )
					{
						$attrValue = $child->getAttribute( 'placeholder' );
						$segment = $this->searchSegment( $attrValue, $items );

						if( !empty( $segment ) )
						{
							$child->setAttribute( 'placeholder', $segment );
						}
					}

					if( $child->hasAttribute( 'type' ) )
					{
						$attrValue = trim( $child->getAttribute( 'type' ) );

						if( strcasecmp( $attrValue, 'submit' ) === 0 || strcasecmp( $attrValue, 'reset' ) === 0 )
						{
							if( $child->hasAttribute( 'value' ) )
							{
								$attrValue = $child->getAttribute( 'value' );
								$segment = $this->searchSegment( $attrValue, $items );

								if( !empty( $segment ) )
								{
									$child->setAttribute( 'value', $segment );
								}
							}
						}
					}

					if( strcasecmp( $child->nodeName, 'img' ) === 0 )
					{
						if( $child->hasAttribute( 'src' ) )
						{
							$metaAttrValue = trim( $child->getAttribute( 'src' ) );

							if( !empty( $metaAttrValue ) )
							{
								if( strpos( $metaAttrValue, '//' ) === false )
								{
									if( strncmp( $metaAttrValue, $this->site_url, strlen( $this->site_url ) ) !== 0 )
									{
										$newAttrValue = rtrim( $this->site_url, '/' ) . '/' . ltrim( $metaAttrValue, '/' );

										$child->setAttribute( 'src', $newAttrValue );
									}
								}
							}
						}
					}

					if( strcasecmp( $child->nodeName, 'a' ) === 0 )
					{
						if( $child->hasAttribute( 'href' ) )
						{
							$metaAttrValue = trim( $child->getAttribute( 'href' ) );

							if( !empty( $metaAttrValue ) )
							{
								if( $metaAttrValue !== '#' )
								{
									if( $child->hasAttribute( 'translate' ) )
									{
										$metaAttrValue = trim( $child->getAttribute( 'translate' ) );

										if( $metaAttrValue === 'no' )
										{
											
										}

										else
										{
											$temp = $this->replaceLink( $metaAttrValue, $this->language_code );
											$child->setAttribute( 'href', $temp );
										}
									}

									else
									{
										$temp = $this->replaceLink( $metaAttrValue, $this->language_code );
										$child->setAttribute( 'href', $temp );
									}
								}
							}
						}
					}

					if( strcasecmp( $child->nodeName, 'meta' ) === 0 )
					{
						if( $child->hasAttribute( 'name' ) )
						{
							$metaAttributeName = trim( $child->getAttribute( 'name' ) );

							if( strcasecmp( $metaAttributeName, 'description' ) === 0 || strcasecmp( $metaAttributeName, 'keywords' ) === 0 )
							{
								if( $child->hasAttribute( 'content' ) )
								{
									$metaAttrValue = $child->getAttribute( 'content' );
									$segment = $this->searchSegment( $metaAttrValue, $items );

									if( !empty( $segment ) )
									{
										$child->setAttribute( 'content', $segment );							
									}
								}
							}
						}
					}

					if( strcasecmp( $child->nodeName, 'script' ) !== 0 && strcasecmp( $child->nodeName, 'style' ) !== 0 )
					{
						if( $child->hasAttribute( 'translate' ) )
						{
							$metaAttrValue = trim( $child->getAttribute( 'translate' ) );

							if( $metaAttrValue === 'no' )
							{
								
							}

							else
							{
								$this->domRecursiveApply( $child, $items );								
							}
						}

						else
						{
							$this->domRecursiveApply( $child, $items );
						}
					}
				}
			}
		}
	}

	function replaceLink( $value, $language_code )
	{
		$aPos = strpos( $value, '//' );

		if( $aPos !== false )
		{
			$ePos = strpos( $this->site_url, '//' );
			$aStr = substr( $value, $aPos );
			$eStr = substr( $this->site_url, $ePos );
			$eLen = strlen( $eStr );

			if( strncmp( $aStr, $eStr, $eLen ) !== 0 )
			{
				return $value;
			}
		}

		//

		$link = parse_url( $value );

		if( stripos( $link['path'], 'wp-admin' ) === false )
		{
			$link['path'] = substr_replace( $link['path'], $this->site_prefix . '' . $language_code . '/', 0, strlen( $this->site_prefix ) );

			return $this->unparse_url( $link );
		}

		return $value;
	}

	function unparse_url( $parsed_url )
	{
		$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

		return "$scheme$user$pass$host$port$path$query$fragment"; 
	}

	/*
	 * 
	 * 
	 * */

	function domLoad( $output )
	{
		$doc = new DOMDocument();

		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;

		libxml_use_internal_errors( true );

		$doc->loadHTML( $output );

		libxml_clear_errors();

		return $doc;
	}

	function searchSegment( $value )
	{
		$source_text = html_entity_decode( $value );

		if( !empty( $this->items ) && !empty( trim( $source_text ) ) )
		{
			foreach( $this->items as $item )
			{
				$source_text2 = html_entity_decode( $item['source_text'] );

				if( strcasecmp( trim( $source_text ), trim( $source_text2 ) ) === 0 )
				{
					return str_replace( trim( $source_text ), $item['translate_text'], $source_text );
				}
			}
		}
	}

	function _shutdown()
	{
		if( !is_admin() && !empty( $this->language_code ) )
		{
			$temp = array();
			$size = ob_get_level();

			for( $i = 0; $i < $size; $i++ )
			{
				$str = ob_get_clean();

				array_unshift( $temp, $str );
			}

			$output = implode( '', $temp );

			//

			if( extension_loaded('xml') )
			//~ if( false )
			{
				$doc = $this->domLoad( $output );

				$this->domRecursiveRead( $doc );

				sort( $this->segments );

				$response = $this->send( 'POST', '/website/translate/', array(
					'referrer' => $this->referrer,
					'source_language' => $this->source_language,
					'target_language' => $this->language_code,
					'segments' => $this->segments,
				));

				if( !empty( $response ) )
				{
					$this->items = $response;

					$output = $this->replaceSegments( $output );

					//~ $doc = $this->domLoad( $output );

					//~ $this->domRecursiveApply( $doc, $response );

					//~ if( strncmp( $output, '<!DOCTYPE html>', 9 ) === 0 )
					//~ {
						//~ $output = '<!DOCTYPE html>' .  "\n" . $doc->saveHTML( $doc->documentElement );
					//~ }

					//~ else
					//~ {
						//~ $output = $doc->saveHTML( $doc->documentElement );
					//~ }
				}
			}

			echo $output;
		}
	}

	private function send( $request_method, $request_uri, $query = array() )
	{
		$ch = curl_init();

		if( in_array( $request_method, array( 'PUT', 'POST', 'DELETE', 'PATCH' ) ) )
		{
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $query ) );
		}

		else
		{
			$request_uri .= '?' . http_build_query( $query );
		}

		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $request_method );
		curl_setopt( $ch, CURLOPT_URL, CONVEYTHIS_API_URL . $request_uri );
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Accept: text/html',
			'Content-Type: text/html',
			'X-Api-Key: ' . $this->api_key
		));

		$response = curl_exec( $ch );

		curl_close($ch);

		//~ echo $response;
		//~ return;

		if( !empty( $response ) )
		{
			$data = json_decode( $response, true );

			if( !empty( $data ) )
			{
				if( $data['status'] == 'success' )
				{
					return $data['data'];
				}

				else
				{
					if( !empty( $data['message'] ) )
					{
						if( is_admin() )
						{
							if( !function_exists( 'add_settings_error' ) )
							{
								include_once( ABSPATH . 'wp-admin/includes/template.php' );
							}

							$message = esc_html__( $data['message'], 'conveythis-translate' );

							if( strpos( $message, '#' ) )
							{
								$message = str_replace( '#', '<a target="_blank" href="https://www.conveythis.com/dashboard/pricing/?utm_source=widget&utm_medium=wordpress">' . __( 'change plan', 'conveythis-translate' ) . '</a>', $message );
							}
							add_settings_error( 'conveythis-translate', '501', $message, 'error' );
						}
					}
				}
			}
		}
	}

    public static function Instance()
    {
        if( self::$instance === null )
        {
            self::$instance = new ConveyThis();
        }
        return self::$instance;
    }

    public static function plugin_activate()
    {
		add_option( 'api_key', '' );
		add_option( 'source_language', '' );
		add_option( 'target_languages', array() );
		add_option( 'style_change_language', array() );
		add_option( 'style_change_flag', array() );
		add_option( 'style_flag', 'rect' );
		add_option( 'style_text', 'full-text' );
		add_option( 'style_position_vertical', 'bottom' );
		add_option( 'style_position_horizontal', 'right' );
		add_option( 'style_indenting_vertical', '0' );
		add_option( 'style_indenting_horizontal', '24' );
		add_option( 'auto_translate', '1' );
		add_option( 'hide_conveythis_logo', '0' );
		add_option( 'alternate', '1' );
		add_option( 'accept_language', '0' );
		add_option( 'blockpages', array() );
		add_option( 'show_javascript', '1' );
		add_option( 'mb_admin_notice', array() );
    }

    public static function plugin_deactivate()
    {

    }

    public static function plugin_uninstall()
    {
		delete_option( 'api_key' );
		delete_option( 'source_language' );
		delete_option( 'target_languages' );
		delete_option( 'style_change_language' );
		delete_option( 'style_change_flag' );
		delete_option( 'style_flag' );
		delete_option( 'style_text' );
		delete_option( 'style_position_vertical' );
		delete_option( 'style_position_horizontal' );
		delete_option( 'style_indenting_vertical' );
		delete_option( 'style_indenting_horizontal' );
		delete_option( 'auto_translate' );
		delete_option( 'hide_conveythis_logo' );
		delete_option( 'alternate' );
		delete_option( 'accept_language' );
		delete_option( 'blockpages' );
		delete_option( 'show_javascript' );
		delete_option( 'mb_admin_notice' );
    }
}

register_activation_hook( __FILE__, array( 'ConveyThis', 'plugin_activate' ) );
register_deactivation_hook( __FILE__, array( 'ConveyThis', 'plugin_deactivate' ) );
register_uninstall_hook( __FILE__, array( 'ConveyThis', 'plugin_uninstall' ) );

add_action( 'plugins_loaded', array( 'ConveyThis', 'Instance' ), 10 );

class conveythis_admin_notices
{
	public $config;
	public $notice_spam = 0;
	public $notice_spam_max = 2;

	public function __construct( $config = array() )
	{
		add_action( 'admin_init', array( $this, 'mb_admin_notice_ignore' ) );
		add_action( 'admin_init', array( $this, 'mb_admin_notice_temp_ignore' ) );
		add_action( 'admin_notices', array( $this, 'mb_display_admin_notices' ) );
	}

	public function mb_admin_notices()
	{
		$settings = get_option('mb_admin_notice');

		if( !isset($settings['disable_admin_notices']) || ( isset($settings['disable_admin_notices']) && $settings['disable_admin_notices'] == 0 ))
		{
			if( current_user_can('manage_options') )
			{
				return true;
			}
		}
		return false;
	}

	public function change_admin_notice_conveythis( $admin_notices )
	{

	 if (!$this->mb_admin_notices()) {
		return false;
	 }

	 foreach( $admin_notices as $slug => $admin_notice)
	 {

		if ($this->mb_anti_notice_spam()) {
		   return false;
		}

		if (isset($admin_notices[$slug]['pages']) && is_array($admin_notices[$slug]['pages'])) {
		   if (!$this->mb_admin_notice_pages($admin_notices[$slug]['pages'])) {
			  return false;
		   }
		}


		if (!$this->mb_required_fields($admin_notices[$slug]))
		{
		   $current_date = current_time("m/d/Y");
		   $start = ( isset($admin_notices[$slug]['start']) ? $admin_notices[$slug]['start'] : $current_date );
		   $start = date("m/d/Y");
		   $date_array = explode('/', $start);
		   $interval = ( isset($admin_notices[$slug]['int']) ? $admin_notices[$slug]['int'] : 0 );

		   $date_array[1] += $interval;
		   $start = date("m/d/Y", mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));


		   $admin_notices_option = get_option('mb_admin_notice', array());

		   if (!array_key_exists($slug, $admin_notices_option)) {
			  $admin_notices_option[$slug]['start'] = date("m/d/Y");
			  $admin_notices_option[$slug]['int'] = $interval;
			  update_option('mb_admin_notice', $admin_notices_option);
		   }

		   $admin_display_check = ( isset($admin_notices_option[$slug]['dismissed']) ? $admin_notices_option[$slug]['dismissed'] : 0 );
		   $admin_display_start = ( isset($admin_notices_option[$slug]['start']) ? $admin_notices_option[$slug]['start'] : $start );
		   $admin_display_interval = ( isset($admin_notices_option[$slug]['int']) ? $admin_notices_option[$slug]['int'] : $interval );
		   $admin_display_msg = ( isset($admin_notices[$slug]['msg']) ? $admin_notices[$slug]['msg'] : '' );
		   $admin_display_title = ( isset($admin_notices[$slug]['title']) ? $admin_notices[$slug]['title'] : '' );
		   $admin_display_link = ( isset($admin_notices[$slug]['link']) ? $admin_notices[$slug]['link'] : '' );

		   $output_css = false;

		   if ($admin_display_check == 0 && strtotime($admin_display_start) <= strtotime($current_date))
		   {
			  $query_str = ( isset($admin_notices[$slug]['later_link']) ? $admin_notices[$slug]['later_link'] : esc_url(add_query_arg('mb_admin_notice_ignore', $slug)) );
			  if (strpos($slug, 'promo') === FALSE) {

				 echo '<div class="update-nag mb-admin-notice" style="width:95%!important;">
						   <div></div>
							<strong><p>' . $admin_display_title . '</p></strong>
							<strong><p style="font-size:14px !important">' . $admin_display_msg . '</p></strong>
							<strong><ul>' . $admin_display_link . '</ul></strong>
						  </div>';
			  } else {
				 echo '<div class="admin-notice-promo">';
				 echo $admin_display_msg;
				 echo '<ul class="notice-body-promo blue">
								' . $admin_display_link . '
							  </ul>';
				 echo '</div>';
			  }
			  $this->notice_spam += 1;
			  $output_css = true;
		   }
		}
	 }
	}

	public function mb_anti_notice_spam()
	{
	 if ($this->notice_spam >= $this->notice_spam_max) {
		return true;
	 }
	 return false;
	}

	public function mb_admin_notice_ignore()
	{
	 if (isset($_GET['mb_admin_notice_ignore'])) {
		$admin_notices_option = get_option('mb_admin_notice', array());
		$admin_notices_option[$_GET['mb_admin_notice_ignore']]['dismissed'] = 1;
		update_option('mb_admin_notice', $admin_notices_option);
		$query_str = remove_query_arg('mb_admin_notice_ignore');
		wp_redirect($query_str);
		exit;
	 }
	}

	public function mb_admin_notice_temp_ignore()
	{

	 if (isset($_GET['mb_admin_notice_temp_ignore'])) {
		$admin_notices_option = get_option('mb_admin_notice', array());
		$current_date = current_time("m/d/Y");
		$date_array = explode('/', $current_date);
		$interval = (isset($_GET['mb_int']) ? $_GET['mb_int'] : 7);

		$date_array[1] += $interval;
		$new_start = date("m/d/Y", mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));

		$admin_notices_option[$_GET['mb_admin_notice_temp_ignore']]['start'] = $new_start;
		$admin_notices_option[$_GET['mb_admin_notice_temp_ignore']]['dismissed'] = 0;
		update_option('mb_admin_notice', $admin_notices_option);
		$query_str = remove_query_arg(array('mb_admin_notice_temp_ignore', 'mb_int'));
		wp_redirect($query_str);
		exit;
	 }
	}

	public function mb_admin_notice_pages( $pages )
	{
	 foreach ($pages as $key => $page) {
		if (is_array($page)) {
		   if (isset($_GET['page']) && $_GET['page'] == $page[0] && isset($_GET['tab']) && $_GET['tab'] == $page[1]) {
			  return true;
		   }
		} else {
		   if ($page == 'all') {
			  return true;
		   }
		   if (get_current_screen()->id === $page) {
			  return true;
		   }
		   if (isset($_GET['page']) && $_GET['page'] == $page) {
			  return true;
		   }
		}
		return false;
	 }
	}

	public function mb_required_fields( $fields )
	{
	 if (!isset($fields['msg']) || ( isset($fields['msg']) && empty($fields['msg']) )) {
		return true;
	 }
	 if (!isset($fields['title']) || ( isset($fields['title']) && empty($fields['title']) )) {
		return true;
	 }
	 return false;
	}

	public function mb_display_admin_notices()
	{
		$two_week_review_ignore = add_query_arg(array('mb_admin_notice_ignore' => 'two_week_review'));
		$two_week_review_temp = add_query_arg(array('mb_admin_notice_temp_ignore' => 'two_week_review', 'int' => 7));

		$notices['two_week_review'] = array(
			'title' => 'Leave A ConveyThis Review?',
			'msg' => 'We love and care about you. ConveyThis Team is putting our maximum efforts to provide you the best functionalities.<br> We would really appreciate if you could spend a couple of seconds to give a Nice Review to the plugin for motivating us!',
			'link' => '<span class="dashicons dashicons-external conveythis-admin-notice"></span><span class="conveythis-admin-notice"><a href="https://wordpress.org/support/plugin/conveythis-translate/reviews/?filter=5#postform" target="_blank" class="conveythis-admin-notice-link">' . 'Sure! I\'d love to!' . '</a></span>
					<span class="dashicons dashicons-smiley conveythis-admin-notice"></span><span class="conveythis-admin-notice"><a href="' . $two_week_review_ignore . '" class="conveythis-admin-notice-link"> ' . 'I\'ve already left a review' . '</a></span>
					<span class="dashicons dashicons-calendar-alt conveythis-admin-notice"></span><span class="conveythis-admin-notice"><a href="' . $two_week_review_temp . '" class="conveythis-admin-notice-link">' . 'Maybe Later' . '</a></span>',
			'later_link' => $two_week_review_temp,
			'int' => 7
		);

		$this->change_admin_notice_conveythis( $notices );
	}
	
	
}

