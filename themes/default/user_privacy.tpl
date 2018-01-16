<div class="col-md-9">

    <div class="page-header">
    <h1>Privacy Settings - {$smarty.session.USERNAME}</h1>
    </div>

    <form class="form-horizontal" method="POST" action="">

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Allow friend Invitations</label>
            <div class="col-sm-3">
                <select name="user_friend_invition" class="form-control">
                <option {if $user_info.user_friend_invition eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_friend_invition eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Enable private message</label>
            <div class="col-sm-3">
                <select name="user_private_message" class="form-control">
                <option {if $user_info.user_private_message eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_private_message eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Enable private message</label>
            <div class="col-sm-3">
                <select name="user_private_message" class="form-control">
                <option {if $user_info.user_private_message eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_private_message eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Public favourites</label>
            <div class="col-sm-3">
                <select name="user_favourite_public" class="form-control">
                <option {if $user_info.user_favourite_public eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_favourite_public eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Public playlists</label>
            <div class="col-sm-3">
                <select name="user_playlist_public" class="form-control">
                <option {if $user_info.user_playlist_public eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_playlist_public eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Allow Profile comments</label>
                <div class="col-sm-3">
                <select name="user_profile_comment" class="form-control">
                <option {if $user_info.user_profile_comment eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_profile_comment eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="hotlink_protection" class="col-sm-3 control-label">Receive Email from Admin</label>
            <div class="col-sm-3">
                <select name="user_subscribe_admin_mail" class="form-control">
                <option {if $user_info.user_subscribe_admin_mail eq '1'}selected{/if} value="1">Yes</option>
                <option {if $user_info.user_subscribe_admin_mail eq '0'}selected{/if} value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <input class="btn btn-default btn-lg btn-block" type="submit" name="submit" value="Save">
            </div>
        </div>

    </form>

</div>

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>