<?php

use smartcat\form\Form;
use SmartcatSupport\descriptor\Option;
use SmartcatSupport\Plugin;
use SmartcatSupport\util\TicketUtils;

$statuses = get_option( Option::STATUSES, Option\Defaults::$STATUSES );
$status = get_post_meta( $ticket->ID, 'status', true );

?>

<div class="panel panel-default ticket-details">

    <div class="panel-body">

        <div class="lead"><?php _e( in_array( $status, $statuses ) ? $statuses[ $status ] : $statuses['new'], Plugin::ID ); ?></div>

        <p>
            <?php _e( 'Since ', Plugin::ID ); ?>
            <?php _e( human_time_diff( strtotime( $ticket->post_date ), current_time( 'timestamp' ) ) . ' ago', Plugin::ID ); ?>
        </p>

        <p><?php _e( 'From ' . get_the_date( 'l F j, Y', $ticket ), Plugin::ID ); ?></p>

    </div>

</div>

<div class="panel panel-default customer-details">

    <div class="panel-heading">

        <p class="panel-title"><?php _e( 'Customer Details', Plugin::ID ); ?></p>

    </div>

    <div class="panel-body">

        <div class="media">

            <div class="media-left">

                <?php echo get_avatar( $ticket, 48, '', '', array( 'class' => 'img-circle media-object' ) ); ?>

            </div>

            <div class="media-body" style="width: auto">

                <p>

                    <strong class="media-middle"><?php echo get_the_author_meta( 'display_name', $ticket->post_author ); ?></strong>

                </p>

                <p><?php _e( 'Email: ', Plugin::ID ); echo TicketUtils::ticket_author_email( $ticket ); ?></p>

            </div>

        </div>

    </div>

</div>

<div class="panel panel-default ticket-properties">

    <div class="panel-heading">

        <p class="panel-title"><?php _e( 'Ticket Properties', Plugin::ID ); ?></p>

    </div>

    <div class="panel-body">

        <form class="ticket-status-form">

            <?php $form = include_once Plugin::plugin_dir( Plugin::ID ) . '/config/ticket_status_form.php'; ?>

            <?php foreach( $form->fields as $field ) : ?>

                <div class="form-group">

                    <label><?php echo $field->label; ?></label>

                    <?php $field->render(); ?>

                </div>

            <?php endforeach; ?>

            <input type="hidden" name="id" value="<?php echo $ticket->ID; ?>" />

            <div class="row">

                <div class="bottom col-sm-12">

                    <button type="submit" class="button button-submit">

                        <?php _e( get_option( Option::SAVE_BTN_TEXT, Option\Defaults::SAVE_BTN_TEXT ) ); ?>

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<?php do_action( 'support_ticket_side_bar', $ticket ); ?>
