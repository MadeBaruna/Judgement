@extends('profile.index')

@section('title', 'Profile')

@section('active_groups', 'active')

@section('profile')
    <button class="ui right floated green labeled icon button new_group_button">
        <i class="add icon"></i>
        Create New Group
    </button>
    <div class="profile">
        <h1>Your Groups</h1>
        @if(count($invites) > 0)
            <h3>Group Invite</h3>
            <div class="ui divided list">
                @foreach($invites as $invite)
                    <div class="item">
                        @php($group_invite = Judgement\Group::find($invite->group_id))
                        <img class="ui avatar image" src="{{ $group_invite->picture() }}"/>
                        <div class="middle aligned content">
                            {{ $group_invite->name }}
                            <div class="divider"></div>
                            <form method="POST" action="{{ url('/profile/groups/confirm/' . $group_invite->id)}}">
                                {{ csrf_field() }}
                                <button type="submit" value="accept" name="group_invite"
                                        class="ui green small compact button">Accept
                                </button>
                                <button type="submit" value="decline" name="group_invite"
                                        class="ui red small compact button">Decline
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="ui segment new_box" style="display: none;">
            <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
                  method="POST" action="{{ url('/profile/groups/new') }}">
                {{ csrf_field() }}
                <div class="field {{ $errors->has('group_name') ? 'error' : '' }}">
                    <label>Group Name</label>
                    <input type="text" name="group_name" placeholder="Group Name">
                </div>

                <button type="submit" class="ui primary submit button">Submit New Group</button>

                <div class="ui error message">
                    <ul class="list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </div>

        @foreach($groups as $group)
            @php($members = $group->members)

            <div class="ui segments">
                <div class="ui clearing secondary segment">
                    @if($group->id == Auth::user()->current_group_id)
                        <span class="ui green horizontal label">
                            Active Group
                        </span>
                    @else
                        <button class="ui right floated compact small button active_group"
                                data-group="{{ $group->id }}" data-name="{{ $group->name }}">
                            Set As Active Group
                        </button>
                    @endif
                    <img class="ui avatar image" src="{{ $group->picture() }}"/> {{ $group->name }}
                    @if($group->leader_id == Auth::user()->id)
                        <button class="ui right floated compact small button edit_group">Edit</button>
                        <button class="ui right floated compact small red icon button trash_group"
                                data-group="{{ $group->id }}" data-name="{{ $group->name }}">
                            <i class="trash icon"></i>
                        </button>
                    @else
                        <button class="ui right floated compact small red button leave_group"
                                data-group="{{ $group->id }}" data-name="{{ $group->name }}">
                            Leave
                        </button>
                    @endif
                </div>
                <div class="ui segment info_box">
                    <div class="ui horizontal list">
                        @foreach($members as $member)
                            <div class="item">
                                <img class="ui avatar image" src="{{ $member->picture() }}">
                                <div class="content">
                                    {{ $member->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="ui segment group_pic_box hidden" style="display: none;">
                    <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}" method="POST"
                          action="{{ url('/profile/groups/picture/' . $group->id)}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="field">
                            <label>Group Picture</label>
                            <div class="ui action input fluid">
                                <input type="text" readonly class='loader active inline'>
                                <input type="file" name="image" accept="image/*">
                                <div class="ui icon button">
                                    <i class="upload icon"></i>
                                </div>
                            </div>
                            <div class="ui error message">
                                <ul class="list">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="ui button">Upload</button>
                    </form>
                </div>
                <div class="ui segment member_box hidden" style="display: none;">
                    <form class="ui form" method="POST" action="{{ url('/profile/groups/edit/' . $group->id) }}">
                        {{ csrf_field() }}
                        <div class="field">
                            <label>Edit Member</label>
                            <div class="ui multiple selection dropdown member">
                                <input name="member" type="hidden" value="<?php
                                foreach ($members as $member) {
                                    if ($group->leader_id != $member->id) {
                                        echo $member->id . ',';
                                    }
                                }
                                ?>">
                                <i class="dropdown icon"></i>
                                <div class="default text">No Member to Remove</div>
                                <div class="menu">
                                    @foreach($members as $member)
                                        @if($group->leader_id != $member->id)
                                            <div class="item" data-value="{{ $member->id }}">
                                                <img class="ui avatar image" src="{{ $member->picture() }}"/>
                                                {{ $member->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="ui button">Edit</button>
                    </form>
                </div>
                <div class="ui segment invite_box hidden" style="display: none;">
                    <form class="ui form" method="POST" action="{{ url('/profile/groups/invite/' . $group->id)}}">
                        {{ csrf_field() }}
                        <div class="field">
                            <label>Invite Member</label>
                            <div class="ui multiple search selection dropdown invite">
                                <input name="invite" type="hidden">
                                <i class="dropdown icon"></i>
                                <div class="default text">Email Address</div>
                                <div class="menu"></div>
                            </div>
                        </div>
                        <button type="submit" class="ui button">Invite</button>
                    </form>
                </div>
            </div>
        @endforeach

        @if(count($groups) == 0)
            <p>You have no group.</p>
        @endif
    </div>

    <div class="ui small basic modal delete_group_modal">
        <div class="ui icon header">
            <i class="trash icon"></i>
            Delete This Group?
        </div>
        <div class="content">
            <p>Are you sure to delete group <span class="group_name"></span>?
                All submissions and scores related to this group will be deleted.
                This action cannot be undone.</p>
        </div>
        <div class="actions">
            <form class="delete_group_form" method="POST" action="">
                {{ csrf_field() }}
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Cancel
                </div>
                <button type="submit" class="ui green ok inverted button">
                    <i class="trash icon"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="ui small basic modal active_group_modal">
        <div class="ui icon header">
            <i class="check icon"></i>
            Active This Group?
        </div>
        <div class="content">
            <p>You will be participating as <span class="group_name"></span> if you enter a group contest.</p>
        </div>
        <div class="actions">
            <form class="active_group_form" method="POST" action="">
                {{ csrf_field() }}
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Cancel
                </div>
                <button type="submit" class="ui green ok inverted button">
                    <i class="check icon"></i>
                    Active
                </button>
            </form>
        </div>
    </div>

    <div class="ui small basic modal leave_group_modal">
        <div class="ui icon header">
            <i class="exit icon"></i>
            Leave This Group?
        </div>
        <div class="content">
            <p>Are you sure want to leave group <span class="group_name"></span>?</p>
        </div>
        <div class="actions">
            <form class="leave_group_form" method="POST" action="">
                {{ csrf_field() }}
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Cancel
                </div>
                <button type="submit" class="ui green ok inverted button">
                    <i class="check icon"></i>
                    Leave
                </button>
            </form>
        </div>
    </div>
@endsection
