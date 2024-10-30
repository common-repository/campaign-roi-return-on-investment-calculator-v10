<?php
/*
  Plugin Name: PPC & Media campaign ROI calculator
  Plugin URI: http://blog.affiliscore.com/2011/08/16/campaign-roi-calculator-wordpress-plugin/
  Description: A plugin that calculates a PPC & Media campaign ROI calculator in your widgets
  Version: 1.0
  Author: Yoav Shalev
  Author URI: http://YoavShalev.com
  License: GPLv2
 */

// use widgets_init action hook to execute custom function
add_action('widgets_init', 'affilicore_wp_ppc_media_roi_calculator_register_widgets');

//register our widget
function affilicore_wp_ppc_media_roi_calculator_register_widgets() {
    register_widget('affilicore_wp_ppc_media_roi_calculator');
    wp_enqueue_script("jquery");
    if (is_admin()) {
        wp_enqueue_style('farbtastic');
        wp_enqueue_script('farbtastic');
    }else{
         
          
            wp_register_script('organictabs-jquery',plugin_dir_url( __FILE__ ).'js/organictabs.jquery.js',array('jquery'), '1.0' );  
            wp_enqueue_script('organictabs-jquery');
            wp_register_script('vtip-jquery',plugin_dir_url( __FILE__ ).'js/vtip.js',array('jquery'), '1.0' );  
            wp_enqueue_script('vtip-jquery');
            wp_register_style('organictabs-jquery-style',  plugin_dir_url( __FILE__ ).'css/style.css','','1.0' );
            wp_enqueue_style('organictabs-jquery-style');

        
     }
}

//boj_widget_my_info class
class affilicore_wp_ppc_media_roi_calculator extends WP_Widget {

    //process the new widget
    function affilicore_wp_ppc_media_roi_calculator() {
        $widget_ops = array( 
			'classname' => 'affilicore_wp_ppc_media_roi_calculator_class', 
			'description' => 'Display a special calculator.' 
			); 
        $this->WP_Widget( 'affilicore_wp_ppc_media_roi_calculator','Campaign ROI Calculator', $widget_ops );
    }
 
     //build the widget settings form
    function form($instance) {
        $defaults = array( 'title' => 'Campaign ROI Calculator','color_border' => '#123456','show_plugin_by'=>'on','border_pixel'=>1 ,'color' => '#123456','color_text' => '#123456' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        $show_plugin_by =$instance['show_plugin_by'];
        $color_border = $instance['color_border'];
        $border_pixel = $instance['border_pixel'];
        $color = $instance['color'];
        $color_text = $instance['color_text'];        
        ?>
            <p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>"  type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
            <p>Border width: <input class="widefat" name="<?php echo $this->get_field_name( 'border_pixel' ); ?>"  type="text" value="<?php echo esc_attr( $border_pixel ); ?>" /></p>
            <p>Support AffiliScore - Display our logo with a link to http://Affiliscore.com ? <input name="<?php echo $this->get_field_name( 'show_plugin_by' ); ?>"  type="checkbox" <?php checked( $show_plugin_by, 'off' ); ?> /></p>
            <p>Border Color: <input class="widefat" name="<?php echo $this->get_field_name( 'color_border' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color_border_ppc'<?php }?>  type="text" value="<?php echo esc_attr( $color_border ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker_border_ppc"></div>
            <p>Background color: <input class="widefat" name="<?php echo $this->get_field_name( 'color' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color_ppc'<?php }?>  type="text" value="<?php echo esc_attr( $color ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker_ppc"></div>
            <p>Text Color: <input class="widefat" name="<?php echo $this->get_field_name( 'color_text' ); ?>" <?php if($this->number!=''){ ?> id='<?php echo $this->number;?>_color_text_ppc'<?php }?>  type="text" value="<?php echo esc_attr( $color_text ); ?>" /></p>
            <div id="<?php echo $this->number;?>_colorpicker_text_ppc"></div>
            <?php if($this->number!=''){?>        
            <script type="text/javascript">
                (function($) {
                    $(document).ready(function() {
                              $('#<?php echo $this->number;?>_colorpicker_border_ppc').farbtastic('#<?php echo $this->number;?>_color_border_ppc');
                                $('#<?php echo $this->number;?>_colorpicker_ppc').farbtastic('#<?php echo $this->number;?>_color_ppc');
                                 $('#<?php echo $this->number;?>_colorpicker_text_ppc').farbtastic('#<?php echo $this->number;?>_color_text_ppc');
                           
                    });
                })(jQuery); 
            </script>
          <?php   } ?>
            <?php
            
            
    }
 
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['show_plugin_by']=strip_tags($new_instance['show_plugin_by']);
        $instance['color_border'] = strip_tags($new_instance['color_border']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['color_text'] = strip_tags($new_instance['color_text']);
        $instance['border_pixel'] = strip_tags($new_instance['border_pixel']);

        return $instance;
    }
 
    //display the widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        ?>
                    
        <?php
        $title = apply_filters('widget_title', $instance['title']);
        $show_plugin_by=empty( $instance['show_plugin_by'] ) ? 0 : 1; 
        $color = empty($instance['color']) ? '&nbsp;' : $instance['color'];
        $color_border = empty($instance['color_border']) ? '#123456' : $instance['color_border'];
        $border_pixel = empty($instance['border_pixel']) ? '1' : $instance['border_pixel'];
        $color_text = empty($instance['color_text']) ? '&nbsp;' : $instance['color_text'];
        
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
      
        
        ?>
        <style type="text/css">

        .affilicore_wp_ppc_media_roi_calculator_class {background:<?php echo $color; ?>; color:<?php echo $color_text; ?>;
        border: <?php echo $border_pixel; ?>px solid <?php echo $color_border; ?>;
        }
        .affilicore_wp_ppc_media_roi_calculator_class h3  {
           font-weight: bolder;  
           padding-left: 7px;
        }
        .affilicore_wp_ppc_media_roi_calculator_class #power_by{
           background: white;

        }

        .affilicore_wp_ppc_media_roi_calculator_class p{
           padding-left: 7px;
        }
        .affilicore_wp_ppc_media_roi_calculator_class b{
            font-size: 14px;
            color:black;
        }



        </style>
        <script>

            function round_up (val, precision) {

                power = Math.pow (10, precision);
                poweredVal = Math.ceil (val * power);
                result = poweredVal / power;

                return result;
            }

            (function($) {
                
                 affilicore_wp_ppc_media_roi_calculator_url='<?php echo plugin_dir_url(__FILE__); ?>';
                /* Common function */
                /* Common function */
                $.fn.showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc =function (id,budget,cost_per_click,conversion_rate,comission_per_sale){
                                         
                    // calculation 
                    click_visitor=budget/cost_per_click;
                    conversions=(click_visitor*conversion_rate)/100;
                        
                    revenue_mode=conversions*comission_per_sale;
                    profit=revenue_mode-budget;
                    roi=(profit/budget)*100;
                    // show
                    //$('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').css("height", "");     
                    if($('#'+id).html()==''){
                        //alert('no value');
                        $('.affilicore_wp_ppc_media_roi_calculator_class .nav li > a[href=#tabs-1]').click();
                    
                        $('#'+id).html(
                            "<p><b>You are likely to get:</b><br/>"
                            + 'Clicks (Visitors)' + '  '+round_up(click_visitor,3)+ '   <br/>'
                            + 'Conversions'+ '  '+round_up(conversions,3)   + '<br/>'
                            + '<b>Results:</b></br>'
                            + 'Revenue Made' + '  '+round_up(revenue_mode,3) + '  <br/>'
                            + 'Profit' + '  '+round_up(profit,3)  + ' <br/>'
                            + 'ROI' + '  '+round_up(roi,3) + ' (%)  <br/>'
                      
                            );
                        // $('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').css('height','200px');
                            
                        new_change_height=$('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').height() + $('#'+id).height();
                           
                        $('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').css('height',new_change_height+'px');
                    }else{
                        // alert('got value');
                        $('#'+id).html(
                            "<p><b>You are likely to get:</b><br/>"
                            + 'Clicks (Visitors)' + '  '+round_up(click_visitor,3)+ '   <br/>'
                            + 'Conversions'+ '  '+round_up(conversions,3)   + '<br/>'
                            + '<b>Results:</b></br>'
                            + 'Revenue Made' + '  '+round_up(revenue_mode,3) + '  <br/>'
                            + 'Profit' + '  '+round_up(profit,3)  + ' <br/>'
                            + 'ROI' + '  '+round_up(roi,3) + ' (%)  <br/>'
                      
                            );
                            
                    }
                   
                }
                 
                $.fn.showresult_affilicore_wp_ppc_media_roi_calculator_for_media =function (id,budget,cost_per_mille,ctr,conversion_rate,comission_per_sale){

                    // calculation
                    impressions=(budget/cost_per_mille)*1000;
                    click_visitor= (impressions*ctr)/100;
                    conversions=(click_visitor*conversion_rate)/100;
                        
                    revenue_mode=conversions*comission_per_sale;
                    profit=revenue_mode-budget;
                    roi=(profit/budget)*100;
                    if($('#'+id).html()==''){
                   
                        // $('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').css("height", "");

                        $('#'+id).html(
                            "<p><b>You are likely to get:</b><br/>"
                            +'Impression'+'  '+round_up(impressions,3)+' <br/>'
                            + 'Clicks (Visitors)' + '  '+round_up(click_visitor,3)+ '   <br/>'
                            + 'Conversions'+ '  '+round_up(conversions,3)   + '<br/>'
                            + '<b>Results:</b></br>'
                            + 'Revenue Made' + '  '+round_up(revenue_mode,3) + '  <br/>'
                            + 'Profit' + '  '+round_up(profit,3)  + ' <br/>'
                            + 'ROI' + '  '+round_up(roi,3) + '(%)   <br/>'
                      
                            );
                        new_change_height=$('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').height() + $('#'+id).height();
                           
                        $('#tabs-affilicore_wp_ppc_media_roi_calculator .list-wrap').css('height',new_change_height+'px');
                    }else{
                        //alert('got value');
                            
                        $('#'+id).html(
                            "<p><b>You are likely to get:</b><br/>"
                            +'Impression'+'  '+round_up(impressions,3)+' <br/>'
                            + 'Clicks (Visitors)' + '  '+round_up(click_visitor,3)+ '   <br/>'
                            + 'Conversions'+ '  '+round_up(conversions,3)   + '<br/>'
                            + '<b>Results:</b></br>'
                            + 'Revenue Made' + '  '+round_up(revenue_mode,3) + '  <br/>'
                            + 'Profit' + '  '+round_up(profit,3)  + ' <br/>'
                            + 'ROI' + '  '+round_up(roi,3) + '(%)   <br/>'
                      
                            );
                    }
                // show
                   
                }
               
               
                /* End common function */
                $(document).ready(function() {                    
                   // $( "#tabs-affilicore_wp_ppc_media_roi_calculator" ).tabs();
                    
                   
                   
                    
                    /* Tab1 calculation */
                    
                    $('#tab1_cal_button').click(function (){
                        tab1_ppc_budget=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab1_ppc_cost_per_click=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').value;
                        tab1_ppc_conversion_rate=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab1_ppc_comission_per_sale=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab1_button=0;
                        if(isNaN(tab1_ppc_budget) || tab1_ppc_budget=='' ){
                            error_log_on_tab1_button++;
                            alert('Please give a valid number in budget input.');
                            
                        }else if(isNaN(tab1_ppc_cost_per_click) || tab1_ppc_cost_per_click=='' ){
                             error_log_on_tab1_button++;
                            alert('Please give a valid number in cost per click input.');
                        }else if(isNaN(tab1_ppc_conversion_rate) || tab1_ppc_conversion_rate=='' ){
                             error_log_on_tab1_button++;
                            alert('Please give a valid number in conversion rate input.');
                        }
                        else if(isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale=='' ){
                             error_log_on_tab1_button++;
                            alert('Please give a valid number in comission per sale input.');
                        }
                        if(error_log_on_tab1_button==0){
                            //alert(error_log_on_tab1_button);
                            $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc('affilicore_wp_ppc_media_roi_calculator_show_result_tab1',tab1_ppc_budget,tab1_ppc_cost_per_click,tab1_ppc_conversion_rate,tab1_ppc_comission_per_sale);
                        }
                        /*alert('budget:'+tab1_ppc_budget+'</br>'
                            +'Cost per click:'+tab1_ppc_cost_per_click+'</br>'
                            +'Conversion Rate:'+tab1_ppc_conversion_rate+'</br>'
                            +'Commission per sale:'+tab1_ppc_comission_per_sale);*/
 
                    }); 
                    $('#tab1_affilicore_wp_ppc_media_roi_calculator_budget').keyup(function (e){
                        tab1_ppc_budget=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab1_ppc_cost_per_click=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').value;
                        tab1_ppc_conversion_rate=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab1_ppc_comission_per_sale=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                         error_log_on_tab1_button=0;
                        if(isNaN(tab1_ppc_budget) || tab1_ppc_budget=='' ){
                            error_log_on_tab1_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in budget input.');
                            }
                        }else{
                            if(isNaN(tab1_ppc_cost_per_click) || tab1_ppc_cost_per_click=='' || isNaN(tab1_ppc_conversion_rate) || tab1_ppc_conversion_rate =='' || isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale==''){
                                
                            }else{
                             $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc('affilicore_wp_ppc_media_roi_calculator_show_result_tab1',tab1_ppc_budget,tab1_ppc_cost_per_click,tab1_ppc_conversion_rate,tab1_ppc_comission_per_sale);   
                            }
                        }
                        
                    });
                    
                    $('#tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').keyup(function (e){
                        tab1_ppc_budget=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab1_ppc_cost_per_click=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').value;
                        tab1_ppc_conversion_rate=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab1_ppc_comission_per_sale=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                         error_log_on_tab1_button=0;
                        if(isNaN(tab1_ppc_cost_per_click) || tab1_ppc_cost_per_click=='' ){
                            error_log_on_tab1_button++;
                            //alert(e.keyCode+ 'test by aminul');
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in cost per click input.');
                            }
                        }else{
                            if(isNaN(tab1_ppc_budget) || tab1_ppc_budget=='' || isNaN(tab1_ppc_conversion_rate) || tab1_ppc_conversion_rate =='' || isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale==''){
                                
                            }else{
                             $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc('affilicore_wp_ppc_media_roi_calculator_show_result_tab1',tab1_ppc_budget,tab1_ppc_cost_per_click,tab1_ppc_conversion_rate,tab1_ppc_comission_per_sale);   
                            }
                        }
                        
                    });
                     $('#tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').keyup(function (e){
                        tab1_ppc_budget=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab1_ppc_cost_per_click=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').value;
                        tab1_ppc_conversion_rate=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab1_ppc_comission_per_sale=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                         error_log_on_tab1_button=0;
                        if(isNaN(tab1_ppc_conversion_rate) || tab1_ppc_conversion_rate=='' ){
                            error_log_on_tab1_button++;
                             if(e.keyCode!='9'){
                            alert('Please give a valid number in conversion rate input.');
                             }
                        }else{
                            if(isNaN(tab1_ppc_budget) || tab1_ppc_budget=='' || isNaN(tab1_ppc_cost_per_click) || tab1_ppc_cost_per_click =='' || isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale==''){
                                
                            }else{
                             $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc('affilicore_wp_ppc_media_roi_calculator_show_result_tab1',tab1_ppc_budget,tab1_ppc_cost_per_click,tab1_ppc_conversion_rate,tab1_ppc_comission_per_sale);   
                            }
                        }
                        
                    });
                    
                     $('#tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').keyup(function (e){
                        tab1_ppc_budget=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab1_ppc_cost_per_click=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click').value;
                        tab1_ppc_conversion_rate=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab1_ppc_comission_per_sale=document.getElementById('tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                         error_log_on_tab1_button=0;
                        if(isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale=='' ){
                            error_log_on_tab1_button++;
                             if(e.keyCode!='9'){
                            alert('Please give a valid number in comission per sale input.');
                             }
                        }else{
                            if(isNaN(tab1_ppc_budget) || tab1_ppc_budget=='' || isNaN(tab1_ppc_cost_per_click) || tab1_ppc_cost_per_click =='' || isNaN(tab1_ppc_comission_per_sale) || tab1_ppc_comission_per_sale==''){
                                
                            }else{
                             $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_ppc('affilicore_wp_ppc_media_roi_calculator_show_result_tab1',tab1_ppc_budget,tab1_ppc_cost_per_click,tab1_ppc_conversion_rate,tab1_ppc_comission_per_sale);   
                            }
                        }
                        
                    });
                    
                    
                    /* Tab2 calculation */
                     $('#tab2_cal_button').click(function (e){
                       // alert('This is ok2');
                        
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_budget) || tab2_media_budget=='' ){
                            error_log_on_tab2_button++;
                             if(e.keyCode!='9'){
                            alert('Please give a valid number in budget input.');
                             }
                        }else if(isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile=='' ){
                             error_log_on_tab2_button++;
                              if(e.keyCode!='9'){
                            alert('Please give a valid number in cost per mille input.');
                              }
                        }else if(isNaN(tab2_media_ctr) || tab2_media_ctr=='' ){
                             error_log_on_tab2_button++;
                             if(e.keyCode!='9'){
                            alert('Please give a valid number in CTR input.');
                             }
                        }else if(isNaN( tab2_media_conversion_rate) ||  tab2_media_conversion_rate=='' ){
                             error_log_on_tab2_button++;
                              if(e.keyCode!='9'){
                            alert('Please give a valid number in conversion rate input.');
                              }    
                        }
                        else if(isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale=='' ){
                             error_log_on_tab2_button++;
                              if(e.keyCode!='9'){
                            alert('Please give a valid number in comission per sale input.');
                              }    
                    }
                        if(error_log_on_tab2_button==0){
                            //alert(error_log_on_tab1_button);function (id,budget,cost_per_mille,ctr,conversion_rate,comission_per_sale)
                            $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale);
                        }
                        
                    }); 
                    
                    
                     $('#tab2_affilicore_wp_ppc_media_roi_calculator_budget').keyup(function (e){
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_budget) || tab2_media_budget=='' ){
                            error_log_on_tab2_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in budget input.');
                            }
                        }else{
                            if(isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile=='' || isNaN(tab2_media_ctr) || tab2_media_ctr =='' || isNaN(tab2_media_conversion_rate) || tab2_media_conversion_rate==''|| isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale==''){
                                
                            }else{
                                $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale); 
                            }
                        }
                        
                    });
                    
                     $('#tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').keyup(function (e){
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile=='' ){
                            error_log_on_tab2_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in Cost per mile input.');
                            }
                        }else{
                            if(isNaN(tab2_media_budget) || tab2_media_budget=='' || isNaN(tab2_media_ctr) || tab2_media_ctr =='' || isNaN(tab2_media_conversion_rate) || tab2_media_conversion_rate==''|| isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale==''){
                                
                            }else{
                                $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale); 
                            }
                        }
                        
                    });
                    
                     $('#tab2_affilicore_wp_ppc_media_roi_calculator_ctr').keyup(function (e){
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_ctr) || tab2_media_ctr=='' ){
                            error_log_on_tab2_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in budget input.');
                            }
                        }else{
                            if(isNaN(tab2_media_budget) || tab2_media_budget=='' || isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile =='' || isNaN(tab2_media_conversion_rate) || tab2_media_conversion_rate==''|| isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale==''){
                                
                            }else{
                                $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale); 
                            }
                        }
                        
                    });
                    
                     $('#tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').keyup(function (e){
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_conversion_rate) || tab2_media_conversion_rate=='' ){
                            error_log_on_tab2_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in conversion rate input.');
                            }
                        }else{
                            if(isNaN(tab2_media_budget) || tab2_media_budget=='' || isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile =='' || isNaN(tab2_media_ctr) || tab2_media_ctr==''|| isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale==''){
                                
                            }else{
                                $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale); 
                            }
                        }
                        
                    });
                    
                     $('#tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').keyup(function (e){
                        
                        tab2_media_budget=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_budget').value;
                        tab2_media_cost_per_mile=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille').value;
                        tab2_media_ctr=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_ctr').value;
                        tab2_media_conversion_rate=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate').value;
                        tab2_media_comission_per_sale=document.getElementById('tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale').value;
                        error_log_on_tab2_button=0;
                        if(isNaN(tab2_media_comission_per_sale) || tab2_media_comission_per_sale=='' ){
                            error_log_on_tab2_button++;
                            if(e.keyCode!='9'){
                            alert('Please give a valid number in comission per sale input.');
                            }
                        }else{
                            if(isNaN(tab2_media_budget) || tab2_media_budget=='' || isNaN(tab2_media_cost_per_mile) || tab2_media_cost_per_mile =='' || isNaN(tab2_media_ctr) || tab2_media_ctr==''|| isNaN(tab2_media_conversion_rate) || tab2_media_conversion_rate==''){
                                
                            }else{
                                $(this).showresult_affilicore_wp_ppc_media_roi_calculator_for_media('affilicore_wp_ppc_media_roi_calculator_show_result_tab2',tab2_media_budget,tab2_media_cost_per_mile,tab2_media_ctr,tab2_media_conversion_rate,tab2_media_comission_per_sale); 
                               /* $('.nav li > a[href=#tabs-1]').click();
                                alert('ttttt');
                                $('.nav li > a[href=#tabs-2]').click();*/
                        }
                        }
                        
                    });
                    
                    // End tab2
 $("#tabs-affilicore_wp_ppc_media_roi_calculator").organicTabs();
                }); // end document ready


            })(jQuery); 
        </script>
          
        	
        
        <div id="tabs-affilicore_wp_ppc_media_roi_calculator">
           
            <ul class="nav">
                <li class="nav-one"><a href="#tabs-1" class="current">PPC ROI</a></li>
                <li class="nav-two"><a href="#tabs-2">Media ROI</a></li>
            </ul>
           <div class="list-wrap">
            <ul id="tabs-1">
                <p>Your Budget :<input type="text" style="width: 80%" name="tab1_affilicore_wp_ppc_media_roi_calculator_budget" id="tab1_affilicore_wp_ppc_media_roi_calculator_budget"/></p>
                <p>Cost per click <a title="You may add real or decimal number great than 0" class="vtip">(?)</a>:<input type="text" style="width: 80%" name="tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click" id="tab1_affilicore_wp_ppc_media_roi_calculator_cost_per_click"/></p>
                <p>Conversion rate(%)<a title="The conversion rate is measure in percentage, example 1 = 1%" class="vtip">(?)</a>:<input type="text" style="width: 80%" name="tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate" id="tab1_affilicore_wp_ppc_media_roi_calculator_conversion_rate"/></p>
                <p>Commission per sale :<input type="text" style="width: 80%" name="tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale" id="tab1_affilicore_wp_ppc_media_roi_calculator_comission_per_sale"/></p>
                <input type="button" name="tab1_cal_button" id="tab1_cal_button" value="Calculate" /> 
                <br/><br/>
                <div id="affilicore_wp_ppc_media_roi_calculator_show_result_tab1"></div>           
            </ul>
            <ul id="tabs-2" class="hide">
                <p>Your Budget :<input type="text" style="width: 80%" name="tab2_affilicore_wp_ppc_media_roi_calculator_budget" id="tab2_affilicore_wp_ppc_media_roi_calculator_budget"/></p>
                <p>Cost per mille(CPM)<a title="You may add real or decimal number great than 0" class="vtip">(?)</a>:<input type="text" style="width: 80%" name="tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille" id="tab2_affilicore_wp_ppc_media_roi_calculator_cost_per_mille"/></p>
                <p>Click Through Rate (CTR)(%)<a title="The CTR is measure in percentage, example 1 = 1%" class="vtip">(?)</a>:<input type="text" style="width: 80%" name="tab2_affilicore_wp_ppc_media_roi_calculator_ctr" id="tab2_affilicore_wp_ppc_media_roi_calculator_ctr"/></p>
                <p>Conversion rate(%)<a title="The conversion rate is measure in percentage, example 1 = 1%" class="vtip">(?)</a> :<input type="text" style="width: 80%" name="tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate" id="tab2_affilicore_wp_ppc_media_roi_calculator_conversion_rate"/></p>
                <p>Commission per sale :<input type="text" style="width: 80%" name="tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale" id="tab2_affilicore_wp_ppc_media_roi_calculator_comission_per_sale"/></p>
                <input type="button" name="tab2_cal_button" id="tab2_cal_button" value="Calculate" /> 
                 <br/><br/>
                <div id="affilicore_wp_ppc_media_roi_calculator_show_result_tab2"></div>
            </ul>
            </div> 

        </div>
                    
         <?php 
        
         if($show_plugin_by){?>
         <div id="power_by">
             <div style="padding-left: 10px;margin-top: 7px;float: left;" >Plugin By</div><div align="right" style="margin-right: 3px;"><a align="right" href=" http://Affiliscore.com" target="_blank" ><img  src="<?php echo plugin_dir_url( __FILE__ );?>/logo.jpg" alt="Affiliate Marketing" /></a></div>
         </div>
        <?php } ?>
       <?php echo $after_widget;
    }
}
?>