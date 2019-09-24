getMessage(){

	pusheddate=""
	
	currentDate=`date`

	for i in $currentDate

		do

			if [ $i = 'IST' ] 
	
			then 
		
				continue
	
			fi
	
			pusheddate="$pusheddate$i\|"

		done

		eval "$1=$pusheddate"

}

add(){

git add .

echo 'Adding done....\n\n'

}


commit(){
	
	getMessage message

	git commit -m $message


	echo 'Commit done...\n\n'
}

pull(){

	git pull origin master

	echo 'Pull done..\n\n'
}


push(){

	git push origin master
	
	echo 'Push done...\n\n'
}

upload(){
	git init
	add
	commit
	git remote add origin https://github.com/Rupeshdevasam/Music-player.git
	pull
	push


	echo 'Upload done...\n\n'
}

upload
