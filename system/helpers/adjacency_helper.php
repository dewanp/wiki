<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Build admin tree
 *
 * Creates adjacency list for administration
 *
 * @access  public
 * @param   array   tree items
 * @return  string
 */
if ( ! function_exists('build_admin_tree'))
{    
	function build_admin_tree(&$tree)
    {	
	    $output = '';
		
        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
                if (isset($leaf['children']) && ! empty($leaf['children']))
                {
					
					$output .= '<li id="list_' . $leaf['id'] . '"><table width="100%" border="0" class="tblgrid"><tr><td width="65%"><i class="icon-move"></i> ' . $leaf['name'] . '</td><td align="center">'.$leaf['user_names'].'</td><td align="right"><span><a class="btn btn-primary btn-mini" href="'.site_url('admin/displayEditCategory/'.$leaf['id']). '"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-mini" data-toggle="modal" data-type="item" data-href="' . site_url('al/delete/' . $leaf['id']) . '" data-name="'. $leaf['name'].'" href="javascript:void(0);" onclick="deleteCategory('.$leaf['id'].')"><i class="icon-trash icon-white"></i> | Delete</a></span></td></tr></table>' ;
                    $output .= '<ul>' . build_admin_tree($leaf['children']) . '</ul>';
                    $output .= '</li>';
                }
                else
                {
					$output .= '<li id="list_' . $leaf['id'] . '"><table width="100%" border="0" class="tblgrid"><tr><td width="65%"><i class="icon-move"></i> ' . $leaf['name'] . '</td><td align="center">'.$leaf['user_names'].'</td><td align="right"><span><a class="btn btn-primary btn-mini" href="' .site_url('admin/displayEditCategory/' .$leaf['id']). '"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-mini" data-toggle="modal" data-type="item" data-href="' . site_url('al/delete/' . $leaf['id']) . '" data-name="' . $leaf['name'] . '" href="javascript:void(0);" onclick="deleteCategory('.$leaf['id'].')"><i class="icon-trash icon-white"></i> | Delete</a></span></td></tr>
</table></li>';
                }        
            }
			return $output;
        }
    }
}

/**
 * Build tree front
 *
 * Creates adjacency list based on group id or slug
 *
 * @access  public
 * @param   mixed   group id or slug
 * @param   mixed   any attributes
 * @param   array   tree array
 * @return  string
 */
if ( ! function_exists('build_admin_tree_front'))
{
    function build_admin_tree_front(&$tree)
    {	
	    $output = '';
		
        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
                if (isset($leaf['children']) && ! empty($leaf['children']))
                {
					$output .= '<li id="list_' . $leaf['id'] . '"><table width="100%" border="0" class="tblgrid"><tr><td width="80%"><i class="icon-move"></i> <a href="post/showposts/'.$leaf['id'].'"> '. $leaf['name'] .'</a><a href="javascript:void(0);" class="right" onclick="edit_category('.$leaf['id'].')"> Edit </a></td></tr></table>' ;
                    $output .= '<ul>' . build_admin_tree_front($leaf['children']) . '</ul>';
                    $output .= '</li>';
                }
                else
                {
					$output .= '<li id="list_' . $leaf['id'] . '"><table width="100%" border="0" class="tblgrid"><tr><td width="80%"><i class="icon-move"></i><a href="post/showposts/'.$leaf['id'].'"> '. $leaf['name'] .'</a><a href="javascript:void(0);" class="right" onclick="edit_category('.$leaf['id'].')"> Edit </a></td></tr></table></li>';
                }        
            }
			return $output;
        }
    }
}