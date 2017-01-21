<?php
/**
 * Project:     Smarty: the PHP compiling template engine
 * File:        SmartyBC.class.php
 * SVN:         $Id: $
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-discussion-subscribe@googlegroups.com
 *
 * @link http://www.smarty.net/
 * @copyright 2008 New Digital Group, Inc.
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Uwe Tews
 * @author Rodney Rehm
 * @package Smarty
 */
/**
 *
 * @ignore
 *
 */
require (dirname ( __FILE__ ) . '/Smarty.class.php');

/**
 * Smarty Backward Compatability Wrapper Class
 *
 * @package Smarty
 */
class SmartyBC extends Smarty {
	
	/**
	 * Smarty 2 BC
	 * 
	 * @var string
	 */
	public $_version = self::SMARTY_VERSION;
	
	/**
	 * Initialize new SmartyBC object
	 *
	 * @param $options array
	 *       	 options to set during initialization, e.g. array(
	 *        	'forceCompile' => false )
	 */
	public function __construct(array $options = array()) {
		parent::__construct ( $options );
		// register {php} tag
		$this->registerPlugin ( 'block', 'php', 'smarty_php_tag' );
	}
	
	/**
	 * wrapper for assign_by_ref
	 *
	 * @param $tpl_var string
	 *       	 the template variable name
	 * @param
	 *       	 mixed &$value the referenced value to assign
	 */
	public function assign_by_ref($tpl_var, &$value) {
		$this->assignByRef ( $tpl_var, $value );
	}
	
	/**
	 * wrapper for append_by_ref
	 *
	 * @param $tpl_var string
	 *       	 the template variable name
	 * @param
	 *       	 mixed &$value the referenced value to append
	 * @param $merge boolean
	 *       	 flag if array elements shall be merged
	 */
	public function append_by_ref($tpl_var, &$value, $merge = false) {
		$this->appendByRef ( $tpl_var, $value, $merge );
	}
	
	/**
	 * clear the given assigned template variable.
	 *
	 * @param $tpl_var string
	 *       	 the template variable to clear
	 */
	public function clear_assign($tpl_var) {
		$this->clearAssign ( $tpl_var );
	}
	
	/**
	 * Registers custom function to be used in templates
	 *
	 * @param $function string
	 *       	 the name of the template function
	 * @param $function_impl string
	 *       	 the name of the PHP function to register
	 * @param $cacheable bool       	
	 * @param $cache_attrs mixed       	
	 */
	public function register_function($function, $function_impl, $cacheable = true, $cache_attrs = null) {
		$this->registerPlugin ( 'function', $function, $function_impl, $cacheable, $cache_attrs );
	}
	
	/**
	 * Unregisters custom function
	 *
	 * @param $function string
	 *       	 name of template function
	 */
	public function unregister_function($function) {
		$this->unregisterPlugin ( 'function', $function );
	}
	
	/**
	 * Registers object to be used in templates
	 *
	 * @param $object string
	 *       	 name of template object
	 * @param $object_impl object
	 *       	 the referenced PHP object to register
	 * @param $allowed array
	 *       	 list of allowed methods (empty = all)
	 * @param $smarty_args boolean
	 *       	 smarty argument format, else traditional
	 * @param $block_functs array
	 *       	 list of methods that are block format
	 */
	public function register_object($object, $object_impl, $allowed = array(), $smarty_args = true, $block_methods = array()) {
		settype ( $allowed, 'array' );
		settype ( $smarty_args, 'boolean' );
		$this->registerObject ( $object, $object_impl, $allowed, $smarty_args, $block_methods );
	}
	
	/**
	 * Unregisters object
	 *
	 * @param $object string
	 *       	 name of template object
	 */
	public function unregister_object($object) {
		$this->unregisterObject ( $object );
	}
	
	/**
	 * Registers block function to be used in templates
	 *
	 * @param $block string
	 *       	 name of template block
	 * @param $block_impl string
	 *       	 PHP function to register
	 * @param $cacheable bool       	
	 * @param $cache_attrs mixed       	
	 */
	public function register_block($block, $block_impl, $cacheable = true, $cache_attrs = null) {
		$this->registerPlugin ( 'block', $block, $block_impl, $cacheable, $cache_attrs );
	}
	
	/**
	 * Unregisters block function
	 *
	 * @param $block string
	 *       	 name of template function
	 */
	public function unregister_block($block) {
		$this->unregisterPlugin ( 'block', $block );
	}
	
	/**
	 * Registers compiler function
	 *
	 * @param $function string
	 *       	 name of template function
	 * @param $function_impl string
	 *       	 name of PHP function to register
	 * @param $cacheable bool       	
	 */
	public function register_compiler_function($function, $function_impl, $cacheable = true) {
		$this->registerPlugin ( 'compiler', $function, $function_impl, $cacheable );
	}
	
	/**
	 * Unregisters compiler function
	 *
	 * @param $function string
	 *       	 name of template function
	 */
	public function unregister_compiler_function($function) {
		$this->unregisterPlugin ( 'compiler', $function );
	}
	
	/**
	 * Registers modifier to be used in templates
	 *
	 * @param $modifier string
	 *       	 name of template modifier
	 * @param $modifier_impl string
	 *       	 name of PHP function to register
	 */
	public function register_modifier($modifier, $modifier_impl) {
		$this->registerPlugin ( 'modifier', $modifier, $modifier_impl );
	}
	
	/**
	 * Unregisters modifier
	 *
	 * @param $modifier string
	 *       	 name of template modifier
	 */
	public function unregister_modifier($modifier) {
		$this->unregisterPlugin ( 'modifier', $modifier );
	}
	
	/**
	 * Registers a resource to fetch a template
	 *
	 * @param $type string
	 *       	 name of resource
	 * @param $functions array
	 *       	 array of functions to handle resource
	 */
	public function register_resource($type, $functions) {
		$this->registerResource ( $type, $functions );
	}
	
	/**
	 * Unregisters a resource
	 *
	 * @param $type string
	 *       	 name of resource
	 */
	public function unregister_resource($type) {
		$this->unregisterResource ( $type );
	}
	
	/**
	 * Registers a prefilter function to apply
	 * to a template before compiling
	 *
	 * @param $function callable       	
	 */
	public function register_prefilter($function) {
		$this->registerFilter ( 'pre', $function );
	}
	
	/**
	 * Unregisters a prefilter function
	 *
	 * @param $function callable       	
	 */
	public function unregister_prefilter($function) {
		$this->unregisterFilter ( 'pre', $function );
	}
	
	/**
	 * Registers a postfilter function to apply
	 * to a compiled template after compilation
	 *
	 * @param $function callable       	
	 */
	public function register_postfilter($function) {
		$this->registerFilter ( 'post', $function );
	}
	
	/**
	 * Unregisters a postfilter function
	 *
	 * @param $function callable       	
	 */
	public function unregister_postfilter($function) {
		$this->unregisterFilter ( 'post', $function );
	}
	
	/**
	 * Registers an output filter function to apply
	 * to a template output
	 *
	 * @param $function callable       	
	 */
	public function register_outputfilter($function) {
		$this->registerFilter ( 'output', $function );
	}
	
	/**
	 * Unregisters an outputfilter function
	 *
	 * @param $function callable       	
	 */
	public function unregister_outputfilter($function) {
		$this->unregisterFilter ( 'output', $function );
	}
	
	/**
	 * load a filter of specified type and name
	 *
	 * @param $type string
	 *       	 filter type
	 * @param $name string
	 *       	 filter name
	 */
	public function load_filter($type, $name) {
		$this->loadFilter ( $type, $name );
	}
	
	/**
	 * clear cached content for the given template and cache id
	 *
	 * @param $tpl_file string
	 *       	 name of template file
	 * @param $cache_id string
	 *       	 name of cache_id
	 * @param $compile_id string
	 *       	 name of compile_id
	 * @param $exp_time string
	 *       	 expiration time
	 * @return boolean
	 */
	public function clear_cache($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null) {
		return $this->clearCache ( $tpl_file, $cache_id, $compile_id, $exp_time );
	}
	
	/**
	 * clear the entire contents of cache (all templates)
	 *
	 * @param $exp_time string
	 *       	 expire time
	 * @return boolean
	 */
	public function clear_all_cache($exp_time = null) {
		return $this->clearCache ( null, null, null, $exp_time );
	}
	
	/**
	 * test to see if valid cache exists for this template
	 *
	 * @param $tpl_file string
	 *       	 name of template file
	 * @param $cache_id string       	
	 * @param $compile_id string       	
	 * @return boolean
	 */
	public function is_cached($tpl_file, $cache_id = null, $compile_id = null) {
		return $this->isCached ( $tpl_file, $cache_id, $compile_id );
	}
	
	/**
	 * clear all the assigned template variables.
	 */
	public function clear_all_assign() {
		$this->clearAllAssign ();
	}
	
	/**
	 * clears compiled version of specified template resource,
	 * or all compiled template files if one is not specified.
	 * This function is for advanced use only, not normally needed.
	 *
	 * @param $tpl_file string       	
	 * @param $compile_id string       	
	 * @param $exp_time string       	
	 * @return boolean results of {@link smarty_core_rm_auto()}
	 */
	public function clear_compiled_tpl($tpl_file = null, $compile_id = null, $exp_time = null) {
		return $this->clearCompiledTemplate ( $tpl_file, $compile_id, $exp_time );
	}
	
	/**
	 * Checks whether requested template exists.
	 *
	 * @param $tpl_file string       	
	 * @return boolean
	 */
	public function template_exists($tpl_file) {
		return $this->templateExists ( $tpl_file );
	}
	
	/**
	 * Returns an array containing template variables
	 *
	 * @param $name string       	
	 * @return array
	 */
	public function get_template_vars($name = null) {
		return $this->getTemplateVars ( $name );
	}
	
	/**
	 * Returns an array containing config variables
	 *
	 * @param $name string       	
	 * @return array
	 */
	public function get_config_vars($name = null) {
		return $this->getConfigVars ( $name );
	}
	
	/**
	 * load configuration values
	 *
	 * @param $file string       	
	 * @param $section string       	
	 * @param $scope string       	
	 */
	public function config_load($file, $section = null, $scope = 'global') {
		$this->ConfigLoad ( $file, $section, $scope );
	}
	
	/**
	 * return a reference to a registered object
	 *
	 * @param $name string       	
	 * @return object
	 */
	public function get_registered_object($name) {
		return $this->getRegisteredObject ( $name );
	}
	
	/**
	 * clear configuration values
	 *
	 * @param $var string       	
	 */
	public function clear_config($var = null) {
		$this->clearConfig ( $var );
	}
	
	/**
	 * trigger Smarty error
	 *
	 * @param $error_msg string       	
	 * @param $error_type integer       	
	 */
	public function trigger_error($error_msg, $error_type = E_USER_WARNING) {
		trigger_error ( "Smarty error: $error_msg", $error_type );
	}

}

/**
 * Smarty {php}{/php} block function
 *
 * @param $params array
 *       	 parameter list
 * @param $content string
 *       	 contents of the block
 * @param $template object
 *       	 template object
 * @param
 *       	 boolean &$repeat repeat flag
 * @return string content re-formatted
 */
function smarty_php_tag($params, $content, $template, &$repeat) {
	eval ( $content );
	return '';
}

?>