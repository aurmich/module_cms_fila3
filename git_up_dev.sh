git submodule foreach $( readlink -f -- "$0";)
git add --renormalize -A
#git add -A && aicommits  || echo '---------------------------empty'
git add -A && oco  || echo '---------------------------empty'
<<<<<<< HEAD
=======
git add -A && aicommits  || echo '---------------------------empty'
>>>>>>> b320580 (first)
=======
>>>>>>> 777ed0f (conflict)
git push origin dev -u --progress 'origin' || git push --set-upstream origin dev
echo "-------- END PUSH[$(pwd)] ----------";
git checkout dev --
git branch --set-upstream-to=origin/dev dev
git branch -u origin/dev
git merge dev
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 132df7e (rebase 4)
=======
>>>>>>> 0809004 (rebase 7)
=======
>>>>>>> b4f13a0 (rebase 8)
=======
>>>>>>> 568344a (rebase 9)
<<<<<<< HEAD
#git merge master 
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c219998 (first)
<<<<<<< HEAD
#git merge master 
=======
git merge master 
<<<<<<< HEAD
>>>>>>> cbb3d89d (Add and update git code for dev branch)
=======
>>>>>>> d05b8561 (Add git_up_dev.sh script for handling dev branch)
=======
#git merge master 
>>>>>>> decf36077db1822c8ffc41d15fd34ecfcdb048d3
>>>>>>> 1283aaa (first)
<<<<<<< HEAD
>>>>>>> 9146629 (rebase 2)
=======
=======
#git merge master 
>>>>>>> fcc9fa2 (rebase 1/2)
<<<<<<< HEAD
>>>>>>> 132df7e (rebase 4)
=======
=======
=======
>>>>>>> 632fcf11 (Add git_up_dev.sh script for handling dev branch)
<<<<<<< HEAD
git merge master 
=======
>>>>>>> d05b8561 (Add git_up_dev.sh script for handling dev branch)
<<<<<<< HEAD
>>>>>>> a93b63c7 (Add git_up_dev.sh script for handling dev branch)
=======
=======
>>>>>>> d05b8561 (Add git_up_dev.sh script for handling dev branch)
>>>>>>> 632fcf11 (Add git_up_dev.sh script for handling dev branch)
>>>>>>> dd31420 (first)
<<<<<<< HEAD
>>>>>>> e58576c (rebase 5)
=======
=======
>>>>>>> 7bf24b0 (Add git_up_dev.sh script with necessary commands for updating the dev branch)
=======
git merge master 
>>>>>>> 35d1d97 (Add git_up_dev.sh script with necessary commands for updating the dev branch)
=======
git merge master 
>>>>>>> f9571bd (Add git_up_dev.sh script with necessary commands for updating the dev branch)
<<<<<<< HEAD
>>>>>>> c219998 (first)
<<<<<<< HEAD
>>>>>>> 0809004 (rebase 7)
=======
=======
=======
#git merge master 
>>>>>>> b3a67b2 (first)
>>>>>>> eee2a47 (.)
<<<<<<< HEAD
>>>>>>> b4f13a0 (rebase 8)
=======
=======
#git merge master 
>>>>>>> b3a67b2 (first)
>>>>>>> 568344a (rebase 9)
=======
#git merge master 
>>>>>>> 8f35797 (up)
=======
#git merge master 
>>>>>>> 409c33a (.)
=======
#git merge master 
>>>>>>> b320580 (first)
echo "-------- END BRANCH[$(pwd)] ----------";
git submodule update --progress --init --recursive --force --merge --rebase --remote
git checkout dev --
git pull origin dev --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase
#read -p "Press [Enter] key to exit..."
<<<<<<< HEAD
<<<<<<< HEAD
echo "-------- END PULL[$(pwd)] ----------";
<<<<<<< HEAD
=======
<<<<<<< HEAD
echo "-------- END PULL[$(pwd)] ----------";
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
echo "-------- END PULL[$(pwd)] ----------";
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> cbb3d89d (Add and update git code for dev branch)
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> d05b8561 (Add git_up_dev.sh script for handling dev branch)
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> decf36077db1822c8ffc41d15fd34ecfcdb048d3
>>>>>>> 1283aaa (first)
<<<<<<< HEAD
>>>>>>> 9146629 (rebase 2)
=======
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> fcc9fa2 (rebase 1/2)
<<<<<<< HEAD
>>>>>>> 132df7e (rebase 4)
=======
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> dd31420 (first)
<<<<<<< HEAD
>>>>>>> e58576c (rebase 5)
=======
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> c219998 (first)
<<<<<<< HEAD
>>>>>>> 0809004 (rebase 7)
=======
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> b3a67b2 (first)
>>>>>>> 568344a (rebase 9)
=======
>>>>>>> 8f35797 (up)
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> 409c33a (.)
=======
echo "-------- END PULL[$(pwd)] ----------";
>>>>>>> b320580 (first)
