<?php
$url_segment1 = $this->uri->segment(1); 
$url_segment2 = $this->uri->segment(2); 
?>
<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="AskPrabhu">
      <table>
      <tr>
      <td class="AskPrabhuLeft">
      <h2 class="topic WhiteTopic"><?php echo ($url_segment1=="prabhu-chawla" && $url_segment2=="column")? "Power and Politics": "Ask Prabhu";?></h2>
      <h4 class="Italic">Editorial Director of New Indian Express</h4>
      <p>Prabhu Chawla is the Editorial Director of the The New Indian Express group. Spending over thirty years as a reporter editor head of The Indian Today group and previously the former editor of the The Indian Express, Chawla has witnesses and recorded dramatic changes in Indian democracy from the trauma of the Emergency, the pathos of Rajiv Ganshi's rise and fall, the angst of Mandal, the churning of liberalization and the rise of coalition politics.</p>
      </td>
      <td class="AskPrabhuRight">
      <figure>
      <img src="<?php echo image_url; ?>images/FrontEnd/images/prabhu.png" title="Ask Prabhu">
      </figure>
      </td>
      </tr>
      </table>
      </div>
</div>
</div>