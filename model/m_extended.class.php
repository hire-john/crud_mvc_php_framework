<?php

/**
 * 
 * APPLICATION SPECIFIC 
 *
 */
class m_extended extends m_model {

    function NewArticle() {
        $article = new helpArticle ();
        $article = $article->getArticleFromRequest();
        return parent::createNewRecord($article, "articles");
    }

    /**
     * This is an example of a custom internal application,
     * inaccessible externally because it lacks a routing definition in
     * the table.
     *
     * @param $scope string       	
     * @return boolean
     */
    function GetNavigationMenu($scope) {
        // get all routes from database where scope = $scope
        // can be used to get a public website navigation or an admin website
        // navigation
        $item = "ALL";
        $table = "routes";
        $column = "scope";
    }

}