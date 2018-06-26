<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contents')->insert([
        	'id' => 1,
            'content' => '
<h2>Homepage</h2>
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. In egestas faucibus eros, in facilisis elit ultricies ac. Donec dolor nisl, maximus et dui vitae, aliquet pretium nibh. Vivamus sollicitudin quam ut augue tincidunt, eget congue ligula viverra. Vivamus dictum pellentesque quam vel fringilla. Nunc fringilla ut urna nec tincidunt. Donec vestibulum fermentum augue sit amet commodo. Ut tincidunt lacus nec eros blandit, nec aliquet enim facilisis. Morbi rhoncus neque eu erat imperdiet, sed placerat risus pretium. Fusce suscipit dolor eget quam mattis efficitur.
</p>
<p>
Integer a ipsum hendrerit, gravida sapien eu, viverra lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec nibh lacinia, ultricies nisi volutpat, elementum mauris. Phasellus pulvinar urna sed augue luctus condimentum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque pulvinar rutrum velit, quis porttitor erat hendrerit sit amet. Aliquam sit amet tempus libero, et ultricies purus. Aenean ornare porttitor interdum.
</p>
<p>
Morbi sed tellus augue. Vestibulum consectetur, nibh quis mollis dictum, arcu diam accumsan ipsum, vitae fermentum dui purus vitae magna. Aliquam elementum, dolor a bibendum egestas, mauris lectus sodales lorem, non tincidunt nisl tellus at mauris. Etiam ullamcorper luctus orci eu vestibulum. Aliquam id maximus felis, eu volutpat nisi. Vivamus eu lectus neque. Morbi pretium nibh at leo blandit dictum. In tempus tortor a lectus viverra, et tempus ante auctor. Integer porttitor vehicula sapien. Vestibulum commodo hendrerit tellus ac scelerisque. Mauris ultrices et enim sed vestibulum.
</p>
<p>
Sed semper mattis lobortis. Suspendisse vitae interdum mi. Vivamus dignissim eleifend enim, eu vulputate nisl gravida nec. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi tellus erat, ullamcorper ut enim ut, posuere facilisis mi. Nunc est velit, viverra id laoreet eget, tempus mollis quam. Phasellus malesuada nec nibh in tristique. Nulla sit amet gravida nisl, id auctor sem. Etiam aliquet nibh neque, et fermentum risus euismod vel. Duis sit amet ante turpis. Sed tempor, lectus eu congue lobortis, massa ligula vestibulum libero, quis luctus enim sapien a nibh. Vestibulum eget nunc aliquam, finibus turpis in, pharetra tellus. Fusce gravida nisi massa, venenatis volutpat tortor tristique et.
</p>
<p>
Etiam in urna bibendum, luctus ex eu, posuere nulla. Donec ut dui nulla. Aliquam non auctor quam. Maecenas facilisis, arcu id molestie feugiat, elit nunc mattis lorem, vel ultricies ligula tellus eget metus. Integer cursus mauris eu ligula ullamcorper, id sollicitudin leo finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque sollicitudin nisi in nulla vehicula condimentum. Pellentesque tristique lacinia est, sed vulputate nisi mattis vitae. Phasellus fringilla imperdiet tempus.
</p>
            ',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('contents')->insert([
            'id' => 2,
            'content' => '
<p>
Sed semper mattis lobortis. Suspendisse vitae interdum mi. Vivamus dignissim eleifend enim, eu vulputate nisl gravida nec. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi tellus erat, ullamcorper ut enim ut, posuere facilisis mi. Nunc est velit, viverra id laoreet eget, tempus mollis quam. Phasellus malesuada nec nibh in tristique. Nulla sit amet gravida nisl, id auctor sem. Etiam aliquet nibh neque, et fermentum risus euismod vel. Duis sit amet ante turpis. Sed tempor, lectus eu congue lobortis, massa ligula vestibulum libero, quis luctus enim sapien a nibh. Vestibulum eget nunc aliquam, finibus turpis in, pharetra tellus. Fusce gravida nisi massa, venenatis volutpat tortor tristique et.
</p>
<p>
Etiam in urna bibendum, luctus ex eu, posuere nulla. Donec ut dui nulla. Aliquam non auctor quam. Maecenas facilisis, arcu id molestie feugiat, elit nunc mattis lorem, vel ultricies ligula tellus eget metus. Integer cursus mauris eu ligula ullamcorper, id sollicitudin leo finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque sollicitudin nisi in nulla vehicula condimentum. Pellentesque tristique lacinia est, sed vulputate nisi mattis vitae. Phasellus fringilla imperdiet tempus.
</p>

            ',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('contents')->insert([
            'id' => 3,
            'content' => '
<h2>About</h2>
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. In egestas faucibus eros, in facilisis elit ultricies ac. Donec dolor nisl, maximus et dui vitae, aliquet pretium nibh. Vivamus sollicitudin quam ut augue tincidunt, eget congue ligula viverra. Vivamus dictum pellentesque quam vel fringilla. Nunc fringilla ut urna nec tincidunt. Donec vestibulum fermentum augue sit amet commodo. Ut tincidunt lacus nec eros blandit, nec aliquet enim facilisis. Morbi rhoncus neque eu erat imperdiet, sed placerat risus pretium. Fusce suscipit dolor eget quam mattis efficitur.
</p>
<p>
Integer a ipsum hendrerit, gravida sapien eu, viverra lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec nibh lacinia, ultricies nisi volutpat, elementum mauris. Phasellus pulvinar urna sed augue luctus condimentum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque pulvinar rutrum velit, quis porttitor erat hendrerit sit amet. Aliquam sit amet tempus libero, et ultricies purus. Aenean ornare porttitor interdum.
</p>
<p>
Morbi sed tellus augue. Vestibulum consectetur, nibh quis mollis dictum, arcu diam accumsan ipsum, vitae fermentum dui purus vitae magna. Aliquam elementum, dolor a bibendum egestas, mauris lectus sodales lorem, non tincidunt nisl tellus at mauris. Etiam ullamcorper luctus orci eu vestibulum. Aliquam id maximus felis, eu volutpat nisi. Vivamus eu lectus neque. Morbi pretium nibh at leo blandit dictum. In tempus tortor a lectus viverra, et tempus ante auctor. Integer porttitor vehicula sapien. Vestibulum commodo hendrerit tellus ac scelerisque. Mauris ultrices et enim sed vestibulum.
</p>
            ',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
