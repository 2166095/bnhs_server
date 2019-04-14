<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

    <div class="contentpage">
        <div class="row">
            <div class="eventwidget">
                <div class="contleft">
                    <div class="header">
                        <p> 
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Statement of Accounts</span>
                            <span>School Year: </span>
                        </p>
                    </div>
                    <div class="cont" id="soa">      
                        <div class="conthead">
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Balance: &nbsp;  &#8369; <?php $run->getBalance(); ?></p>

                        </div>
                        <div class="head" id="soahead">
                                <p id="header"> 
                                    <span>History of Payment</span>
                                </p>
                            <table id="soatable">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                                    <?php $run->getPaymentHisto(); ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="contright">
                    <div class="widget">
                    <div class="header">
                        <p><i class="fas fa-file fnt"></i><span> Breakdown</span></p>
                    </div>
                    <div class="widgetcontent">
                        <table>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <?php $run->getBreakdown();?>
                    </table>
                    </div>
            </div>
        </div>
    </div>