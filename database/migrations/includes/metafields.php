<?php
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
