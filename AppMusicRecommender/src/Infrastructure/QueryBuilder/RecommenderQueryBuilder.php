<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 11/12/15
 * Time: 21:48
 */

namespace Infrastructure\QueryBuilder;

class RecommenderQueryBuilder
{
    public static $getArtistGroupQueryBuilder = "
            (   SELECT user_id, id_singer
                FROM Activity
                WHERE user_id = :user_id
                ORDER by date_created desc
                LIMIT 1
            )
            UNION
            (
                SELECT user_id, id_singer
                FROM Activity
                WHERE user_id = :user_id
                GROUP BY id_singer
                ORDER BY COUNT( * ) DESC
                LIMIT 3
            )
            LIMIT 3

    ";
}
