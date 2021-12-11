<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Image;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogImage = ['blog-1.jpg', 'blog-2.jpg', 'blog-3.jpg'];

        for ($i = 1; $i < 10; $i++) {
            $imageKey = $blogImage[array_rand($blogImage)];
            $blog = Blog::create([
                'heading' => "Blog-$i",
                'content' => "<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>",
                'user_id' => rand(1, 5),
            ]);

            $blog->images()->create(['name' => $blogImage[array_rand($blogImage)]]);

            for ($j = 0; $j < 3; $j++)
                Comment::create([
                    'user_id' => rand(1, 5),
                    'blog_id' => $blog->id,
                    'comment' => 'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using'
                ]);
        }
    }
}
