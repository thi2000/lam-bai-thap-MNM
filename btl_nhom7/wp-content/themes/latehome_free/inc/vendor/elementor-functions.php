<?php 
        /**
         * Adding custom icon to icon control in Elementor
         */
        function latehome_free_modify_controls( $controls_registry ) {
            // Get existing icons
            $icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
            // Append new icons
                $new_icons = array_merge(
        array(
            'lexus-icon-airplane' => 'Airplane',
            'lexus-icon-bathtub' => 'Bathtub',
            'lexus-icon-bed' => 'Bed',
            'lexus-icon-building-2' => 'Building 2',
            'lexus-icon-building' => 'Building',
            'lexus-icon-calendar' => 'Calendar',
            'lexus-icon-check' => 'Check',
            'lexus-icon-delivery-truck' => 'Delivery Truck',
            'lexus-icon-dishwasher' => 'Dishwasher',
            'lexus-icon-doc' => 'Doc',
            'lexus-icon-edit' => 'Edit',
            'lexus-icon-fireplace' => 'Fireplace',
            'lexus-icon-first-aid-kit-2' => 'First Aid-Kit-2',
            'lexus-icon-first-aid-kit' => 'First Aid-Kit',
            'lexus-icon-flag-black-shape' => 'Flag Black-Shape',
            'lexus-icon-heart' => 'Heart',
            'lexus-icon-home' => 'Home',
            'lexus-icon-home4_icon_01' => 'Home4_icon_01',
            'lexus-icon-home4_icon_02' => 'Home4_icon_02',
            'lexus-icon-home4_icon_03' => 'Home4_icon_03',
            'lexus-icon-home4_icon_04' => 'Home4_icon_04',
            'lexus-icon-home5_icon_01' => 'Home5_icon_01',
            'lexus-icon-home5_icon_02' => 'Home5_icon_02',
            'lexus-icon-home5_icon_03' => 'Home5_icon_03',
            'lexus-icon-homes' => 'Homes',
            'lexus-icon-house_01' => 'House_01',
            'lexus-icon-house' => 'House',
            'lexus-icon-idea' => 'Idea',
            'lexus-icon-image' => 'Image',
            'lexus-icon-kitchens' => 'Kitchens',
            'lexus-icon-livingroom' => 'Livingroom',
            'lexus-icon-map-2' => 'Map 2',
            'lexus-icon-map' => 'Map',
            'lexus-icon-park' => 'Park',
            'lexus-icon-pdf' => 'Pdf',
            'lexus-icon-photo-camera' => 'Photo Camera',
            'lexus-icon-pin' => 'Pin',
            'lexus-icon-placeholder' => 'Placeholder',
            'lexus-icon-placeholders' => 'Placeholders',
            'lexus-icon-printer' => 'Printer',
            'lexus-icon-profile' => 'Profile',
            'lexus-icon-real-estate' => 'Real Estate',
            'lexus-icon-real-estates' => 'Real Estates',
            'lexus-icon-school' => 'School',
            'lexus-icon-search' => 'Search',
            'lexus-icon-selection' => 'Selection',
            'lexus-icon-set-square-2' => 'Set Square-2',
            'lexus-icon-set-square' => 'Set Square',
            'lexus-icon-share' => 'Share',
            'lexus-icon-shop' => 'Shop',
            'lexus-icon-skyscraper' => 'Skyscraper',
            'lexus-icon-speech-bubble' => 'Speech Bubble',
            'lexus-icon-storage' => 'Storage',
            'lexus-icon-street-view' => 'Street View',
            'lexus-icon-telephone' => 'Telephone',
            'lexus-icon-verify' => 'Verify',
            'lexus-icon-villa' => 'Villa',
            'lexus-icon-wifi' => 'Wifi',
        ),
        $icons
            );
            // Then we set a new list of icons as the options of the icon control
            $controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
        }
        add_action( 'elementor/controls/controls_registered', 'latehome_free_modify_controls', 10, 1 );
        