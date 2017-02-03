<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobs index large-9 medium-8 columns content">
    <h3><?= __('About Us') ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'index'
            ], [
                'escape' => false
            ]
        );
    ?>
    
    <p><strong>The Company</strong></p>
    
    <p>Dev# was founded in 2016 by five Melbourne-based IT professionals under a single vision: To provide a simple and straightforward way for freelance and sole trading develops to find projects that suit their skillset, and, inversely, to allow companies with need for a developer to find the exact skills they need.</p>
    
    <p>The team has a long history of freelance development so bring with them a thorough knowledge of the needs and wants of people in all facets of the software development industry, and are proud to cater to all who need a quick way to obtain needed resources and employment.</p><br />
    
    <p><strong>The Product</strong></p>
    
    <p>The Dev# matchmaking platform went live in November 2016 and was met with immediate popularity, quickly becoming the go-to for freelance developers in Australia. The platform is being expanded and developed constantly, with new features added all the time.</p><br />
    
    <p><strong>The Team</strong></p>
    <table>
        <tr>
            <td width="210"><img src="img/aboutus/michael.jpg"></td>
            <td>Michael Gambold (Lead Developer): Born and bred in Melbourne, Michael brings to the company a wealth of knowledge and experience in all facets of software development, working on everything from the guidance systems on the Apollo lunar landing craft, to the livejournal for the angsty teen who lives down the road from him. He has established himself as team leader for Dev#.</td>
        </tr>
        <tr>
            <td><img src="img/aboutus/david.jpg"></td>
            <td>David Bumford (Database Administrator): The often heard but never seen David seems to reside within cyberspace itself, where he spends 24 hours a day 7 days a week designing and administering relational databases simply by thinking it. The leading theory is that he once stood too close to an SQL database server that was attempting to divide by zero and somehow got absorbed into the hardware, becoming something of a Deus Ex Machina. David's incorporeal form and lack of need of sleep are a great asset to Dev#, and since he has no physical need to eat or participate in a consumerist society, we don't need to pay him either.</td>
        </tr>
        <tr>
            <td><img src="img/aboutus/nathaniel.jpg"></td>
            <td>Nathaniel Gipson (Engine Developer): Nathaniel is the undisputed master of making something from nothing in the world of software. When designing the matchmaking system for Dev#, it was said that he simply willed it into being. Rumours of a hidden polished oil lamp were quickly stamped out when it was widely agreed on that no one in the office believed in genies, and even if they did, they wouldn't waste one of their wishes on a matchmaking algorithm. Nathaniel previously wrote site engines for various other companies, namely Pants Co, Pants ‘R’ Us, and Pants Pants Pants: The Pants People.</td>
        </tr>
        <tr>
            <td><img src="img/aboutus/reece.jpg"></td>
            <td>Reece Matheison (UI Developer and Compliance): Reece is a recent convert to the IT industry, shying away from a mildly successful journalism career when he tried his hand at writing technical documentation, and it won him the 2015 Pulitzer Prize. His attention to detail and creative eye have seen him catapulted into the world of front end user experience development.</td>
        </tr>
        <tr>
            <td><img src="img/aboutus/cam.jpg"></td>
            <td>Cameron Jones (UI Developer and Customer Facing Documentation): Cam claims to originate from the mythical island of Tasmania, despite any evidence suggesting such a place even exists. His claims that the magical kingdom does not yet have electricity means that he is relatively new to the software development industry. Even so, he has found a calling in user experience, both in interface design and documentation, which has propelled his personal slogan 'who ya gonna call?' to unparalleled fame.</td>
        </tr>
    </table>
</div>
