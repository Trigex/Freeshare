<div class="col-md-9">

    {if $smarty.get.welcome eq "1"}

        <div class="page-header">
            <h1>
                Welcome to {$site_name}, {$smarty.session.USERNAME}!
            </h1>

            <p class="lead text-muted">We hope you enjoy your experience. Write anytime to let us know how we can serve you better.</p>

            <h2><i>The {$site_name} Team</i></h2>
        </div>

        <h3>What would you like to do next?</h3>
        <ul>
            <li>
                <h4>
                    <a href="{$base_url}/{$smarty.session.USERNAME}/edit/">Complete your profile page</a>
                    <br>
                    <small>The {$site_name} community wants to know about you.</small>
                </h4>
            </li>
            <li>
                <h4>
                    <a href="{$base_url}/upload/">Upload your videos</a>
                    <br>
                    <small>Share your experiences with the world.</small>
                </h4>
            </li>
            <li>
                <h4>
                    <a href="{$base_url}/channels/">Browse the channels</a>
                    <br>
                    <small>Watch videos organized into categories.</small>
                </h4>
           </li>
            <li>
                <h4>
                    <a href="{$base_url}/recent/">Start watching videos</a>
                    <br>
                    <small>Search and browse 1000's of streaming videos.</small>
                </h4>
            </li>
        </ul>
    {/if}

    <div class="page-header">
        <h1>
            Invite Your Friends
        </h1>

        <p class="lead text-muted">We'll send each person you list below an email invitation to join {$site_name} as your friend or family.</p>
    </div>

    <form action="" method="post" id="invite-friends-form" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-3">Your First Name:</label>
            <div class="col-md-7">
                <input name="first_name" value="{$first_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">{if $smarty.get.UID eq ""}Email Addresses:{else}Send to:{/if}</label>
            <div class="col-md-7">
                {if $smarty.get.UID eq ""}
                    <textarea id="recipients" name="recipients" rows="3" required class="form-control">{$recipients}</textarea>
                    <input type="hidden" name="UID" value="">
                {else}
                    <input type="hidden" name="UID" value="{$smarty.get.UID}">
                    {insert name=id_to_name assign=uname un=$smarty.get.UID}
                    {$uname}
                {/if}
                <div class="help-block">Enter Email Addresses separated by a comma.</div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Your Message:</label>
            <div class="col-md-7">
                {if $smarty.get.UID eq ""}
                    Hello,
                {else}
                    {insert name=id_to_name assign=uname un=$smarty.get.UID}
                    Hello {$uname},
                {/if}
                <br /><br />

                {$site_name} is a new site for sharing and hosting personal videos.<br />

                I have been using {$site_name} to share videos with my friends and family.<br />

                I would like to add you to the list of people I may share videos with.<br /><br />

                Personal message from [{if $first_name ne ""}{$first_name}{else}Your Name{/if}]:<br /><br />

                <textarea name="message" rows="5" class="form-control">Have you heard about {$site_name}? I love this site.</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-lg" name="submit">Send Invite</button>
            </div>
        </div>
    </form>
</div>

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>