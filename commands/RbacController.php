<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\commands\AuthorRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $rule = new AuthorRule;
        $auth->add($rule);

        $viewAnnouncement = $auth->createPermission('viewAnnouncement');
        $viewAnnouncement->description = 'View announcements';
        $auth->add($viewAnnouncement);

        $commentPost = $auth->createPermission('commentPost');
        $commentPost->description = 'Comment on a post';
        $auth->add($commentPost);

        $createAnnouncement = $auth->createPermission('createAnnouncement');
        $createAnnouncement->description = 'Create an announcement';
        $auth->add($createAnnouncement);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete post';
        $auth->add($deletePost);

        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->description = 'Update own post';
        $deleteOwnPost->ruleName = $rule->name;
        $auth->add($deleteOwnPost);

        $createDocument = $auth->createPermission('createDocument');
        $createDocument->description = 'Create a document';
        $auth->add($createDocument);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        $createService = $auth->createPermission('createService');
        $createService->description = 'Create a service';
        $auth->add($createService);

        $createDivision = $auth->createPermission('createDivision');
        $createDivision->description = 'Create a service';
        $auth->add($createDivision);

        $auth->addChild($updateOwnPost, $updatePost);
        $auth->addChild($deleteOwnPost, $deletePost);

        $member = $auth->createRole('member');
        $auth->add($member);
        $auth->addChild($member, $viewAnnouncement);
        $auth->addChild($member, $commentPost);

        $couple_coordinator = $auth->createRole('couple_coordinator');
        $auth->add($couple_coordinator);
        $auth->addChild($couple_coordinator, $member);
        $auth->addChild($couple_coordinator, $createAnnouncement);
        $auth->addChild($couple_coordinator, $createUser);
        $auth->addChild($couple_coordinator, $createService);
        $auth->addChild($couple_coordinator, $createDivision);
        $auth->addChild($couple_coordinator, $createDocument);
        $auth->addChild($couple_coordinator, $updateOwnPost);
        $auth->addChild($couple_coordinator, $deleteOwnPost);

        $head = $auth->createRole('head');
        $auth->add($head);
        $auth->addChild($head, $couple_coordinator);
        $auth->addChild($head, $updatePost);
        $auth->addChild($head, $deletePost);
    }
}