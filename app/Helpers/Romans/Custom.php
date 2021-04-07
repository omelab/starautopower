<?php
//app/Helpers/Romans/Custom.php
namespace App\Helpers\Romans; 
use Illuminate\Support\Facades\DB;

class Custom {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function get_username($id) {
        $user = DB::table('users')->where('id', $id)->first();
         
        return (isset($user->name) ? $user->name : '');
    }

    //Nested Category
    /**
     * @param array $cagetories
     * 
     * @return nested array 
     */
    public static function Nested($array)
    {
    	$trees=[];

    	foreach ($array as $tree) {
            $trees[$tree->id] = $tree->title;
            if (count($tree->childs)) {
                foreach ($tree->childs as $childs) {
                    $trees[$childs->id] = '- '.$childs->title;
                    if (count($childs->childs)) {
                        foreach ($childs->childs as $childs2) {
                            $trees[$childs2->id] = '- - '.$childs2->title;
                        } 
                    }
                } 
            }
        }

        return $trees;
    }

    /**
     * @param get  id title
     * 
     * @return array
     */
    public static function get_cities() {
        $cities = DB::table('cities')->where('title', '!=', 'All')->orderBy('title', 'ASC')->pluck('title', 'id');         
        return $cities;
    }


    /**
     * @param get  id title
     * 
     * @return array
     */
    public static function get_area_cities($id) {
        $areas = DB::table('areas')->where('city_id', $id)->orderBy('title', 'ASC')->pluck('title', 'id');
        return $areas;
    }

    /**
     * @param get slug
     * 
     * @return Boolean when match category by slug
     */
    public static function get_activeslug($slug = NULL)
    {   
        $cslug = request()->segment(2);

        if ($slug == NULL) {
           return false;
        }

        if ($slug == $cslug) {            
            return 'active';
        }

        if (isset($cslug) && !empty($cslug)) {
            $fq = DB::table('categories')->where('slug', $cslug)->first();

            if ($fq  && $fq->parent_id != 0) {
                $child = DB::table('categories')->where('id',  $fq->parent_id)->first();

                if ( $slug == $child->slug ) {
                    return 'active opened';
                }else{

                    $child2 = DB::table('categories')->where('id',  $child->parent_id)->first();

                    if ($child2 && $slug == $child2->slug ) {
                        return 'active opened';
                    }
                }
            }
        
        }
    }

    /**
    * @param get slug
    * 
    * @return Boolean when match category by slug
    */
    public static function get_breadcumb()
    {   
        $return = '<ul class="breadcumbs"><li><a href="'. url('/') .'"> Home</a></li>';

        $seg1 = request()->segment(1);
        if ($seg1 =='detsils') {
            $pid = request()->segment(2);
            $catid = DB::table('category_product')->where('product_id', $pid)->pluck('category_id')->first();
            $cslug = DB::table('categories')->where('id', $catid)->pluck('slug')->first();
        }else if ($seg1 =='category') {
            $cslug = request()->segment(2);
        }else if($seg1 =='products' || $seg1 =='services'){
            $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url($seg1).'"> '.$seg1.'</a></li>';
        }
        


        if (isset($cslug) && !empty($cslug)) { 
            $fq = DB::table('categories')->where('slug', $cslug)->first();

            if ($fq  && $fq->parent_id == 0) {
                $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $fq->slug ).'"> '.$fq->title.'</a></li>';
            }else{

                $child = DB::table('categories')->where('id', $fq->parent_id)->first();

                if ($child  && $child->parent_id == 0) {
                $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $child->slug ).'"> '.$child->title.'</a></li>';
                }else{

                    $child2 = DB::table('categories')->where('id', $child->parent_id)->first();

                    if ($child2  && $child2->parent_id == 0) {
                    $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $child2->slug ).'"> '.$child2->title.'</a></li>';
                    }else{
                        $child3 = DB::table('categories')->where('id', $child2->parent_id)->first();

                        if ($child3  && $child3->parent_id == 0) {
                        $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $child3->slug ).'"> '.$child3->title.'</a></li>';
                        }
                                                
                        $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $child2->slug ).'"> '.$child2->title.'</a></li>';

                    }
                    
                    $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $child->slug ).'"> '.$child->title.'</a></li>';

                }

                $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/category/'. $fq->slug ).'"> '.$fq->title.'</a></li>';

            }                
        } 

        if ($seg1 =='detsils') {
            $pid = request()->segment(2);
            $ptitle =  DB::table('products')->where('id',$pid)->pluck('title')->first();

            $return .= '<li><span><i class="fa fa-angle-right"></i></span><a href="'.url('/details/'. $pid ).'"> '. $ptitle.'</a></li>';

        }

        $return .=  '</ul>';

        return   $return;
    }

    /**
    * @param get slug
    * 
    * @return Boolean when match category by slug
    */
    public static function get_discountPrice($cartcontent, $total){
        $regPrice = 0;

        if (!is_object($cartcontent) || !(array)$cartcontent) {
           return 0;
        }

        foreach($cartcontent as $cartItem){
            $rprice = $cartItem->options->regprice > $cartItem->price ? $cartItem->options->regprice : $cartItem->price;
            $regPrice += (int)( $rprice * $cartItem->qty );
        }

        if ( $regPrice > $total) {
           return  ( $regPrice - $total );
        }

        return 0;
    }

}